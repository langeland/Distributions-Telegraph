<?php
namespace Langeland\Telegraph\Command;

/*
 * This file is part of the Langeland.Telegraph package.
 */

use Langeland\Telegraph\Domain\Model\Telegram;
use Langeland\Telegraph\Domain\Model\Telegraph;
use Langeland\Telegraph\Domain\Repository\TelegramRepository;
use Langeland\Telegraph\Service\TelegramService;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Cli\CommandController;

/**
 * @Flow\Scope("singleton")
 */
class TelegramCommandController extends CommandController
{

    /**
     * @var TelegramRepository
     * @Flow\Inject
     */
    protected  $telegramRepository;



    /**
     * @var TelegramService
     * @Flow\Inject
     */
    protected  $telegramService;


    /**
     * An example command
     *
     * The comment of this command method is also used for TYPO3 Flow's help screens. The first line should give a very short
     * summary about what the command does. Then, after an empty line, you should explain in more detail what the command
     * does. You might also give some usage example.
     *
     * It is important to document the parameters with param tags, because that information will also appear in the help
     * screen.
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
