<?php

namespace Langeland\TelegraphUserInterface\Controller;

/*
 * This file is part of the Langeland.TelegraphUserInterface package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;
use Langeland\TelegraphCore\Domain\Model\Telegraph;

class TelegraphController extends ActionController
{

    /**
     * @Flow\Inject
     * @var \Langeland\TelegraphCore\Domain\Repository\TelegraphRepository
     */
    protected $telegraphRepository;

    /**
     * @Flow\Inject
     * @var \Langeland\TelegraphCore\Service\TelegraphService
     */
    protected $telegraphService;

    /**
     * @Flow\Inject
     * @var \Langeland\TelegraphCore\Domain\Repository\TelegramRepository
     */
    protected $telegramRepository;

    /**
     * @return void
     */
    public function indexAction()
    {
        $this->view->assign('telegraphs', $this->telegraphRepository->findAll());
    }

    /**
     * @param \Langeland\TelegraphCore\Domain\Model\Telegraph $telegraph
     * @return void
     */
    public function showAction(Telegraph $telegraph)
    {
        $this->view->assign('telegraph', $telegraph);

//        $status = $this->telegraphService->getStatus($telegraph);
//        $this->view->assign('status', $status);

        $telegrams = $this->telegramRepository->findQueuedByTelegraph($telegraph);
        $this->view->assign('telegrams', $telegrams);
    }

    /**
     * @return void
     */
    public function newAction()
    {
    }

    /**
     * @param \Langeland\TelegraphCore\Domain\Model\Telegraph $newTelegraph
     * @return void
     * @throws \Neos\Flow\Mvc\Exception\StopActionException
     * @throws \Neos\Flow\Persistence\Exception\IllegalObjectTypeException
     */
    public function createAction(Telegraph $newTelegraph)
    {
        $this->telegraphRepository->add($newTelegraph);
        $this->addFlashMessage('Created a new telegraph. ' . $newTelegraph->getIdentifier());
        $this->redirect('show', null, null, ['telegraph' => $newTelegraph]);

//        return 'ok: ' . $newTelegraph->getIdentifier();
    }

    /**
     * @param \Langeland\TelegraphCore\Domain\Model\Telegraph $telegraph
     * @return void
     */
    public function editAction(Telegraph $telegraph)
    {
        $this->view->assign('telegraph', $telegraph);
    }

    /**
     * @param \Langeland\TelegraphCore\Domain\Model\Telegraph $telegraph
     * @return void
     * @throws \Neos\Flow\Mvc\Exception\StopActionException
     * @throws \Neos\Flow\Persistence\Exception\IllegalObjectTypeException
     */
    public function updateAction(Telegraph $telegraph)
    {
        $this->telegraphRepository->update($telegraph);
        $this->addFlashMessage('Updated the telegraph.');
        $this->redirect('index');
    }

    /**
     * @param \Langeland\TelegraphCore\Domain\Model\Telegraph $telegraph
     * @return void
     * @throws \Neos\Flow\Mvc\Exception\StopActionException
     * @throws \Neos\Flow\Persistence\Exception\IllegalObjectTypeException
     */
    public function deleteAction(Telegraph $telegraph)
    {
        $this->telegraphRepository->remove($telegraph);
        $this->addFlashMessage('Deleted a telegraph.');
        $this->redirect('index');
    }

}
