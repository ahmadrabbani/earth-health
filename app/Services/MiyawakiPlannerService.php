<?php

namespace App\Services;

class MiyawakiPlannerService
{
    public function plan(float $areaSqM, int $treeGap): array
    {
        $possible = $areaSqM >= 100;
        $usableArea = $possible ? min($areaSqM * 0.15, 500) : 0;
        $recommendedTrees = $possible ? (int) floor($usableArea * 3) : 0; // dense plantation demo rule

        return [
            'miyawaki_possible' => $possible,
            'miyawaki_area_sq_m' => round($usableArea, 2),
            'recommended_trees' => min($recommendedTrees, max($treeGap, $recommendedTrees)),
        ];
    }
}
