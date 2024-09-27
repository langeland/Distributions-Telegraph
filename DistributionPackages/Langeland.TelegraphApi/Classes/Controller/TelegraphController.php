<?php

namespace Langeland\TelegraphApi\Controller;

/*
 * This file is part of the Langeland.TelegraphApi package.
 */

use Langeland\TelegraphCore\Service\TelegramService;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;
use Langeland\TelegraphCore\Domain\Model\Telegraph;

class TelegraphController extends ActionController
{
    /**
     * @var string
     */
    protected $viewFormatToObjectNameMap = array(
        'html' => \Neos\FluidAdaptor\View\TemplateView::class,
        'json' => \Neos\Flow\Mvc\View\JsonView::class
    );

    /**
     * A list of IANA media types which are supported by this controller
     *
     * @var array
     */
    protected $supportedMediaTypes = array('application/json', 'text/html');

    /**
     * @Flow\Inject
     * @var \Langeland\TelegraphCore\Service\TelegraphService
     */
    protected $telegraphService;

    /**
     * @Flow\Inject
     * @var TelegramService
     */
    protected $telegramService;

    /**
     * @param Telegraph $telegraph
     * @return void
     */
    public function checkStatusAction(Telegraph $telegraph)
    {
        $this->telegraphService->setLastSeen($telegraph);
        $status = $this->telegraphService->getStatusByTelegraph($telegraph);
        $this->view->assign('value', $status);
    }

    /**
     * @param Telegraph $telegraph
     * @param string $type
     * @return void
     * @throws \Neos\Flow\Persistence\Exception\IllegalObjectTypeException
     */
    public function deliverTelegramsAction(Telegraph $telegraph, string $type)
    {
        $this->telegraphService->setLastSeen($telegraph);
        $telegrams = $this->telegraphService->getTelegramsByTelegraph($telegraph, $type, null, true);
        $this->view->assign('value', $telegrams);
    }

    /**
     * @param Telegraph $telegraph
     * @param string $type
     * @return string
     * @throws \Neos\Flow\Persistence\Exception\IllegalObjectTypeException
     */
    public function listTelegramsAction(Telegraph $telegraph, string $type)
    {
        $telegrams = $this->telegraphService->getTelegramsByTelegraph($telegraph, $type, null, false);
        $this->view->assign('value', $telegrams);
    }

    /**
     * @param Telegraph $telegraph
     * @return void
     * @throws \Neos\Flow\Http\Exception
     */
    public function pushAction(Telegraph $telegraph)
    {
        $message = $this->request->getHttpRequest()->getContent();
        $this->telegramService->create($telegraph, $message);
        $this->response->setStatus(204);
    }



}
