<?php

namespace Langeland\TelegraphCore\Domain\Model;

/*
 * This file is part of the Langeland.TelegraphCore package.
 */

use Langeland\TelegraphCore\Service\TelegramService;
use Langeland\TelegraphCore\Service\TelegraphService;
use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class Telegraph
{

    /**
     * @var TelegraphService
     * @Flow\Inject
     */
    protected $telegraphService;

    /**
     * @var string
     *
     * @Flow\Identity
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $identifier;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var bool
     */
    protected $online = false;

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     * @return Telegraph
     */
    public function setIdentifier(string $identifier): Telegraph
    {
        $this->identifier = $identifier;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Telegraph
     */
    public function setName(string $name): Telegraph
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return bool
     */
    public function isOnline(): bool
    {
        return $this->online;
    }

    /**
     * @param bool $online
     * @return Telegraph
     */
    public function setOnline(bool $online): Telegraph
    {
        $this->online = $online;
        return $this;
    }

    public function getStatus()
    {
        return $this->telegraphService->getStatusByTelegraph($this);
    }

    public function getQueuedTelegrams()
    {

    }

}
