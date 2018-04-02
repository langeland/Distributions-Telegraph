<?php

namespace Langeland\Telegraph\Domain\Repository;

/*
 * This file is part of the Langeland.Telegraph package.
 */

use Langeland\Telegraph\Domain\Model\Telegraph;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\Repository;

/**
 * @Flow\Scope("singleton")
 */
class TelegramRepository extends Repository
{

    public function findQueuedByTelegraph(Telegraph $telegraph, string $type = null, int $count = null)
    {
        $query = $this->createQuery();
        $constraints = [];

        $constraints[] = $query->logicalAnd(
            $query->equals('telegraph', $telegraph),
            $query->equals('printed', null)
        );

        if ($type == 'instant') {
            $constraints[] = $query->equals('instant', true);
        }

        if ($type == 'delayed') {
            $constraints[] = $query->equals('instant', false);
        }

        $query->matching($query->logicalAnd($constraints));
        if ($count !== null) {
            $query->setLimit($count);
        }

        return $query->execute();
    }

    public function findOneQueuedByTelegraph(Telegraph $telegraph, $type = null)
    {
        $query = $this->createQuery();
        $constraints = [];

        $constraints[] = $query->logicalAnd(
            $query->equals('telegraph', $telegraph),
            $query->equals('printed', null)
        );

        if ($type == 'instant') {
            $constraints[] = $query->equals('instant', true);
        }

        if ($type == 'delayed') {
            $constraints[] = $query->equals('instant', false);
        }

        $query->matching($query->logicalAnd($constraints));
        return $query->execute()->getFirst();
    }

}
