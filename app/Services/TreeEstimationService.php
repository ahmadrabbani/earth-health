<?php

namespace App\Services;

class TreeEstimationService
{
    public function estimate(float $areaSqM, string $urbanDensity = 'medium'): array
    {
        $treeCoverPercent = match ($urbanDensity) {
            'high' => 6,
            'medium' => 12,
            'low' => 22,
            default => 10,
        };

        $existingTrees = (int) floor(($areaSqM * $treeCoverPercent / 100) / 25);
        $targetTreeCoverPercent = 30;

        $targetTrees = (int) floor(($areaSqM * $targetTreeCoverPercent / 100) / 25);
        $treeGap = max(0, $targetTrees - $existingTrees);

        return [
            'tree_cover_percent' => $treeCoverPercent,
            'existing_trees' => $existingTrees,
            'tree_gap' => $treeGap,
        ];
    }
}
