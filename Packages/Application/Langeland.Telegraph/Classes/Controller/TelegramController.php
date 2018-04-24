<?php
namespace Langeland\Telegraph\Controller;

/*
 * This file is part of the Langeland.Telegraph package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;
use Langeland\Telegraph\Domain\Model\Telegram;

class TelegramController extends ActionController
{

    /**
     * @Flow\Inject
     * @var \Langeland\Telegraph\Domain\Repository\TelegramRepository
     */
    protected $telegramRepository;

    /**
     * @return void
     */
    public function indexAction()
    {
        $this->view->assign('telegrams', $this->telegramRepository->findAll());
    }

    /**
     * @param \Langeland\Telegraph\Domain\Model\Telegram $telegram
     * @return void
     */
    public function showAction(Telegram $telegram)
    {
        $this->view->assign('telegram', $telegram);
    }

    /**
     * @return void
     */
    public function newAction()
    {
    }

    /**
     * @param \Langeland\Telegraph\Domain\Model\Telegram $newTelegram
     * @return void
     * @throws \Neos\Flow\Mvc\Exception\StopActionException
     * @throws \Neos\Flow\Persistence\Exception\IllegalObjectTypeException
     */
    public function createAction(Telegram $newTelegram)
    {
        $this->telegramRepository->add($newTelegram);
        $this->addFlashMessage('Created a new telegram.');
        $this->redirect('index');
    }

    /**
     * @param \Langeland\Telegraph\Domain\Model\Telegram $telegram
     * @return void
     */
    public function editAction(Telegram $telegram)
    {
        $this->view->assign('telegram', $telegram);
    }

    /**
     * @param \Langeland\Telegraph\Domain\Model\Telegram $telegram
     * @return void
     * @throws \Neos\Flow\Mvc\Exception\StopActionException
     * @throws \Neos\Flow\Persistence\Exception\IllegalObjectTypeException
     */
    public function updateAction(Telegram $telegram)
    {
        $this->telegramRepository->update($telegram);
        $this->addFlashMessage('Updated the telegram.');
        $this->redirect('index');
    }

    /**
     * @param \Langeland\Telegraph\Domain\Model\Telegram $telegram
     * @return void
     * @throws \Neos\Flow\Mvc\Exception\StopActionException
     * @throws \Neos\Flow\Persistence\Exception\IllegalObjectTypeException
     */
    public function deleteAction(Telegram $telegram)
    {
        $this->telegramRepository->remove($telegram);
        $this->addFlashMessage('Deleted a telegram.');
        $this->redirect('index');
    }
}
