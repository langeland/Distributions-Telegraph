<?php

namespace Langeland\TelegraphCore\Domain\Model;

/*
 * This file is part of the Langeland.TelegraphCore package.
 */

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class Telegram
{

    /**
     * @var string
     *
     * @Flow\Identity
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $identifier;

    /**
     * @var Telegraph
     * @ORM\ManyToOne()
     */
    protected $telegraph;

    /**
     * @var \DateTime
     */
    protected $created;

    /**
     * @var \DateTime | null
     * @ORM\Column(nullable=true)
     *
     */
    protected $printed = null;

    /**
     * @var string
     */
    protected $channel = 'default';

    /**
     * @var bool
     */
    protected $instant = false;

    /**
     * @var string|null
     * @ORM\Column(nullable=true)
     */
    protected $tag = null;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    protected $message;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    protected $messageEncoded;

    public function __construct()
    {
        $this->created = new \DateTime();
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     * @return Telegram
     */
    public function setIdentifier(string $identifier): Telegram
    {
        $this->identifier = $identifier;
        return $this;
    }

    /**
     * @return Telegraph
     */
    public function getTelegraph(): Telegraph
    {
        return $this->telegraph;
    }

    /**
     * @param Telegraph $telegraph
     * @return Telegram
     */
    public function setTelegraph(Telegraph $telegraph): Telegram
    {
        $this->telegraph = $telegraph;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     * @return Telegram
     */
    public function setCreated(\DateTime $created): Telegram
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getPrinted(): ?\DateTime
    {
        return $this->printed;
    }

    /**
     * @param \DateTime|null $printed
     * @return Telegram
     */
    public function setPrinted(?\DateTime $printed): Telegram
    {
        $this->printed = $printed;
        return $this;
    }

    /**
     * @return string
     */
    public function getChannel(): string
    {
        return $this->channel;
    }

    /**
     * @param string $channel
     * @return Telegram
     */
    public function setChannel(string $channel): Telegram
    {
        $this->channel = $channel;
        return $this;
    }

    /**
     * @return bool
     */
    public function isInstant(): bool
    {
        return $this->instant;
    }

    /**
     * @param bool $instant
     * @return Telegram
     */
    public function setInstant(bool $instant): Telegram
    {
        $this->instant = $instant;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getTag(): ?string
    {
        return $this->tag;
    }

    /**
     * @param null|string $tag
     * @return Telegram
     */
    public function setTag(?string $tag): Telegram
    {
        $this->tag = $tag;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Telegram
     */
    public function setMessage(string $message): Telegram
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessageEncoded(): string
    {
        return $this->messageEncoded;
    }

    /**
     * @param string $messageEncoded
     * @return Telegram
     */
    public function setMessageEncoded(string $messageEncoded): Telegram
    {
        $this->messageEncoded = $messageEncoded;
        return $this;
    }

}
