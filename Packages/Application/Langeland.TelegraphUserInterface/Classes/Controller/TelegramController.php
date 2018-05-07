<?php
namespace Langeland\TelegraphUserInterface\Controller;

/*
 * This file is part of the Langeland.TelegraphUserInterface package.
 */

use Langeland\TelegraphCore\Domain\Model\Telegraph;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;
use Langeland\TelegraphCore\Domain\Model\Telegram;

class TelegramController extends ActionController
{

    /**
     * @Flow\Inject
     * @var \Langeland\TelegraphCore\Domain\Repository\TelegramRepository
     */
    protected $telegramRepository;

    /**
     * @Flow\Inject
     * @var \Langeland\TelegraphCore\Domain\Repository\TelegraphRepository
     */
    protected $telegraphRepository;

    /**
     * @Flow\Inject
     * @var \Langeland\TelegraphCore\Service\TelegramService
     */
    protected $telegraphService;

    /**
     * @return void
     */
    public function indexAction()
    {
        $this->view->assign('telegrams', $this->telegramRepository->findAll());
    }

    /**
     * @param \Langeland\TelegraphCore\Domain\Model\Telegram $telegram
     * @return void
     */
    public function showAction(Telegram $telegram)
    {
        $this->view->assign('telegram', $telegram);
    }

    /**
     * @param \Langeland\TelegraphCore\Domain\Model\Telegraph|null $telegraph
     * @return void
     */
    public function newAction(Telegraph $telegraph = null)
    {
        $this->view->assignMultiple([
            'telegraph' => $telegraph,
            'telegraphs' => $this->telegraphRepository->findAll()
        ]);
    }

    /**
     * @param \Langeland\TelegraphCore\Domain\Model\Telegram $newTelegram
     * @return void
     * @throws \Neos\Flow\Mvc\Exception\StopActionException
     * @throws \Neos\Flow\Persistence\Exception\IllegalObjectTypeException
     */
    public function createAction(Telegram $newTelegram)
    {
        $newTelegram->setMessageEncoded($this->telegraphService->convert($newTelegram->getMessage()));
        $this->telegramRepository->add($newTelegram);

        $this->addFlashMessage('Created a new telegram. ' . $newTelegram->getIdentifier());
//        $this->redirect('show', 'telegraph', null, ['telegraph' => $newTelegram->getTelegraph()]);
        $this->redirect('new', 'telegram', null, ['telegraph' => $newTelegram->getTelegraph()]);
    }

    /**
     * @param \Langeland\TelegraphCore\Domain\Model\Telegram $telegram
     * @return void
     */
    public function editAction(Telegram $telegram)
    {
        $this->view->assign('telegram', $telegram);
    }

    /**
     * @param \Langeland\TelegraphCore\Domain\Model\Telegram $telegram
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
     * @param \Langeland\TelegraphCore\Domain\Model\Telegram $telegram
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
