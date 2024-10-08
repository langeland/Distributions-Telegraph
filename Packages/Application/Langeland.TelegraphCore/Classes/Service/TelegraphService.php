<?php


namespace Langeland\TelegraphCore\Service;


use Langeland\TelegraphCore\Domain\Model\Telegram;
use Langeland\TelegraphCore\Domain\Model\Telegraph;
use Langeland\TelegraphCore\Domain\Repository\TelegramRepository;
use Neos\Cache\Frontend\VariableFrontend;
use Neos\Flow\Annotations as Flow;

class TelegraphService
{
    /**
     * @var TelegramRepository
     * @Flow\Inject
     */
    protected $telegramRepository;

    /**
     * @var VariableFrontend
     * @Flow\Inject
     */
    protected $onlineCache;

    public function getStatusByTelegraph(Telegraph $telegraph)
    {
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

    public function getStatus(Telegraph $telegraph)
    {
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
     * @param Telegraph $telegraph
     * @param string|null $type
     * @param int|null $count
     * @param bool $shift
     * @return array|null
     * @throws \Neos\Flow\Persistence\Exception\IllegalObjectTypeException
     */
    public function getTelegramsByTelegraph(Telegraph $telegraph, string $type = null, ?int $count = 1, bool $shift = false)
    {

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

    public function getLastSeen(Telegraph $telegraph): ?\DateTime
    {
        $cacheIdentifier = sha1('lastSeen:' . (string)$telegraph->getIdentifier());
        if ($this->onlineCache->has($cacheIdentifier)) {
            return $this->onlineCache->get($cacheIdentifier);
        }
        return null;
    }

    public function setLastSeen(Telegraph $telegraph, \DateTime $dateTime = null)
    {
        if ($dateTime === null) {
            $dateTime = new \DateTime();
        }

        $cacheIdentifier = sha1('lastSeen:' . (string)$telegraph->getIdentifier());
        $this->onlineCache->set($cacheIdentifier, $dateTime, [], 0);

        return;
    }

}