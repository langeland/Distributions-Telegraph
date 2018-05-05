<?php
namespace Langeland\TelegraphCore\Command;

/*
 * This file is part of the Langeland.TelegraphCore package.
 */

use Langeland\TelegraphCore\Domain\Model\Telegraph;
use Langeland\TelegraphCore\Domain\Repository\TelegramRepository;
use Langeland\TelegraphCore\Service\TelegramService;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Cli\CommandController;

/**
 * @Flow\Scope("singleton")
 */
class TelegramCommandController extends CommandController
{

    /**
     * @var TelegramService
     * @Flow\Inject
     */
    protected  $telegramService;

    /**
     * Send telegram
     *
     * @param Telegraph $telegraph
     * @param string $message
     * @return void
     */
    public function createCommand(Telegraph $telegraph, string $message)
    {
        $telegram = $this->telegramService->create($telegraph, $message);
        $this->outputLine('Created telegram %s', [$telegram->getIdentifier()]);
    }
}
