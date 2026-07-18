<?php

namespace Tests\Unit;

use App\Services\DrugPairNormalizer;
use PHPUnit\Framework\TestCase;

class DrugPairNormalizerTest extends TestCase
{
    public function test_it_keeps_the_lower_id_first(): void
    {
        $normalizer = new DrugPairNormalizer();

        $this->assertSame([3, 9], $normalizer->normalize(3, 9));
    }

    public function test_it_normalizes_reversed_input_to_the_same_pair(): void
    {
        $normalizer = new DrugPairNormalizer();

        $this->assertSame([3, 9], $normalizer->normalize(9, 3));
    }

    public function test_it_leaves_identical_ids_unchanged_for_validation_to_handle(): void
    {
        $normalizer = new DrugPairNormalizer();

        $this->assertSame([7, 7], $normalizer->normalize(7, 7));
    }
}
