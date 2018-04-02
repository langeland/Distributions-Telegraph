<?php


namespace Langeland\Telegraph\Service;


use Langeland\Telegraph\Domain\Model\Telegram;
use Langeland\Telegraph\Domain\Model\Token;
use Langeland\Telegraph\Domain\Repository\TelegramRepository;
use Neos\Flow\Annotations as Flow;

class TelegraphService
{
    /**
     * @var TelegramRepository
     * @Flow\Inject
     */
    protected $telegramRepository;

    public function getStatusByToken(Token $token)
    {

        $telegraph = $token->getTelegraph();
        $queuedTelegrams = $this->telegramRepository->findQueuedByTelegraph($telegraph);

        $response = [
            'instant' => [
                'status' => 'empty',
                'count' => 0,
                'telegrams' => []

            ],
            'delayed' => [
                'status' => 'empty',
                'count' => 0,
                'telegrams' => []
            ]
        ];

        if ($queuedTelegrams->count() > 0) {
            $response['instant']['status'] = 'pending';
            $response['instant']['count'] = $queuedTelegrams->count();
        }

        return $response;
    }

    /**
     * @param Token $token
     * @param string $type
     * @param int $count
     * @return Telegram|null
     * @throws \Neos\Flow\Persistence\Exception\IllegalObjectTypeException
     */
    public function shiftTelegramsByToken(Token $token, string $type = null, int $count = 1)
    {
        $telegraph = $token->getTelegraph();
        /** @var Telegram $telegram */
        $telegram = $this->telegramRepository->findQueuedByTelegraph($telegraph, $type, $count);

        if ($telegram === null) {
            return null;
        }

        $telegram->setPrinted(new \DateTime());
        $this->telegramRepository->update($telegram);
        return $telegram;
    }

    public function getTelegramsByToken(Token $token, string $type = null, int $count = 1)
    {
        $telegraph = $token->getTelegraph();
        /** @var Telegram $telegram */
        $telegram = $this->telegramRepository->findQueuedByTelegraph($telegraph, $type, $count);

        if ($telegram === null) {
            return null;
        }

        return $telegram;
    }

}