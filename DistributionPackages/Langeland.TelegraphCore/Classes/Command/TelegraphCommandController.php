<?php

namespace Langeland\TelegraphCore\Command;

/*
 * This file is part of the Langeland.TelegraphCore package.
 */

use Langeland\TelegraphCore\Domain\Model\Telegraph;
use Langeland\TelegraphCore\Domain\Repository\TelegraphRepository;
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

}
