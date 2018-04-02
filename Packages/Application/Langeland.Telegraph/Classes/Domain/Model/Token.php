<?php
namespace Langeland\Telegraph\Domain\Model;

/*
 * This file is part of the Langeland.Telegraph package.
 */

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class Token
{

    /**
     * @var string
     *
     * @Flow\Identity
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var Telegraph
     * @ORM\ManyToOne(inversedBy="tokens")
     */
    protected $telegraph;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Token
     */
    public function setId(string $id): Token
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return Token
     */
    public function setToken(string $token): Token
    {
        $this->token = $token;
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
     * @return Token
     */
    public function setTelegraph(Telegraph $telegraph): Token
    {
        $this->telegraph = $telegraph;
        return $this;
    }




}
