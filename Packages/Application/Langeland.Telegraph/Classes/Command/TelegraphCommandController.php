<?php

namespace Langeland\Telegraph\Command;

/*
 * This file is part of the Langeland.Telegraph package.
 */

use Langeland\Telegraph\Domain\Model\Telegraph;
use Langeland\Telegraph\Domain\Model\Token;
use Langeland\Telegraph\Domain\Repository\TelegraphRepository;
use Langeland\Telegraph\Domain\Repository\TokenRepository;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Cli\CommandController;

/**
 * @Flow\Scope("singleton")
 */
class TelegraphCommandController extends CommandController
{

    /**
     * @var TelegraphRepository
     * @Flow\Inject
     */
    protected $telegraphRepository;

    /**
     * @var TokenRepository
     * @Flow\Inject
     */
    protected $tokenRepository;

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
     * @param string $name
     * @return void
     * @throws \Neos\Flow\Persistence\Exception\IllegalObjectTypeException
     */
    public function createCommand(string $name)
    {
        $telegraph = new Telegraph();
        $telegraph->setName($name);

        $this->telegraphRepository->add($telegraph);
    }

    /**
     * List all telegraphs
     */
    public function listCommand()
    {
        $telegraphs = $this->telegraphRepository->findAll();
        foreach ($telegraphs as $telegraph) {
            \Neos\Flow\var_dump($telegraph);
        }
    }

    /**
     * Generates a new token for the given telegraph
     * @param Telegraph $telegraph
     * @throws \Neos\Flow\Persistence\Exception\IllegalObjectTypeException
     */
    public function generateTokenCommand(Telegraph $telegraph)
    {

        $token = new Token();
        $token
            ->setTelegraph($telegraph)
            ->setToken(\Neos\Flow\Utility\Algorithms::generateRandomToken(32));

        $this->tokenRepository->add($token);

        $this->outputLine('Created new telegraph: ' . $telegraph->getIdentifier());
    }

}
