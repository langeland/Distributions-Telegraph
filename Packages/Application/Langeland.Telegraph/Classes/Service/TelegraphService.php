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
        $delayedTelegrams = $this->telegramRepository->findQueuedByTelegraph($telegraph, 'delayed');
        $instantTelegrams = $this->telegramRepository->findQueuedByTelegraph($telegraph, 'instant');

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

        if ($delayedTelegrams->count() > 0) {
            $response['delayed']['status'] = 'pending';
            $response['delayed']['count'] = $delayedTelegrams->count();
        }

        if ($instantTelegrams->count() > 0) {
            $response['instant']['status'] = 'pending';
            $response['instant']['count'] = $instantTelegrams->count();
        }

        return $response;
    }


    /**
     * @param Token $token
     * @param string|null $type
     * @param int|null $count
     * @param bool $shift
     * @return array|null
     * @throws \Neos\Flow\Persistence\Exception\IllegalObjectTypeException
     */
    public function getTelegramsByToken(Token $token, string $type = null, ?int $count = 1, bool $shift = false)
    {
        $telegraph = $token->getTelegraph();

        $telegrams = $this->telegramRepository->findQueuedByTelegraph($telegraph, $type, $count)->toArray();

        if (count($telegrams) === 0) {
            return null;
        }

        if ($shift === true) {
            foreach ($telegrams as $telegram) {
                $telegram->setPrinted(new \DateTime());
                $this->telegramRepository->update($telegram);
            }
        }

        return $telegrams;
    }

}