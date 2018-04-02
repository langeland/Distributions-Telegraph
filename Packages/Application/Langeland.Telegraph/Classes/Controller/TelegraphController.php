<?php

namespace Langeland\Telegraph\Controller;

/*
 * This file is part of the Langeland.Telegraph package.
 */

use Langeland\Telegraph\Domain\Repository\TokenRepository;
use Langeland\Telegraph\Service\TelegraphService;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;

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
     * @var TokenRepository
     * @Flow\Inject
     */
    protected $tokenRepository;

    /**
     * @var TelegraphService
     * @Flow\Inject
     */
    protected $telegraphService;

    /**
     * @param string $token
     * @return void
     */
    public function checkStatusAction(string $token)
    {
        $token = $this->tokenRepository->findOneByToken($token);

        if ($token === null) {
            return 'invalid token';
        }
        $status = $this->telegraphService->getStatusByToken($token);

        $this->view->assign('value', $status);
    }

    /**
     * @param string $token
     * @param string $type
     * @param int $count
     * @return void
     * @throws \Neos\Flow\Persistence\Exception\IllegalObjectTypeException
     */
    public function deliverTelegramsAction(string $token, string $type, int $count = 1)
    {
        $token = $this->tokenRepository->findOneByToken($token);

        if ($token === null) {
            return 'invalid token';
        }

        $telegrams = $this->telegraphService->shiftTelegramsByToken($token, $type, $count);


        $this->view->assign('value', $telegrams);
    }

    /**
     * @param string $token
     * @param string $type
     * @param int $count
     * @return void
     */
    public function listTelegramsAction(string $token, string $type, int $count = 1)
    {
        $token = $this->tokenRepository->findOneByToken($token);

        if ($token === null) {
            return 'invalid token';
        }

        $telegrams = $this->telegraphService->getTelegramsByToken($token, $type, $count);
        $this->view->assign('value', $telegrams);
    }

}
