<?php

namespace App\Services;

class CarbonEstimationService
{
    public function annualKgFromTrees(int $treeCount): float
    {
        // Conservative demo placeholder.
        // You can later swap this with local species-based values.
        $kgPerTreePerYear = 16.5;

        return round($treeCount * $kgPerTreePerYear, 2);
    }
}
