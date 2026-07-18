<?php

namespace App\Services;

class DrugPairNormalizer
{
    /**
     * Normalize a drug pair so the lower ID is always first.
     *
     * @return array{0:int,1:int}
     */
    public function normalize(int $drugOneId, int $drugTwoId): array
    {
        if ($drugOneId === $drugTwoId) {
            return [$drugOneId, $drugTwoId];
        }

        return $drugOneId < $drugTwoId
            ? [$drugOneId, $drugTwoId]
            : [$drugTwoId, $drugOneId];
    }
}
