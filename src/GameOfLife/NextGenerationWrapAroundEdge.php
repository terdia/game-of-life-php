<?php declare(strict_types=1);

namespace App\GameOfLife;

class NextGenerationWrapAroundEdge implements NextGenerationInterface
{
    use RuleApplier;

    public function generate(array $grid, int $cols, int $rows): array
    {
        $next = $grid;
        for ($i = 0; $i < $cols; $i++) {
            for ($j = 0; $j < $rows; $j++) {
                /** @var Cell $cell */
                $cell = $grid[$i][$j];

                //set live neighbours for current cell
                $cell->setTotalLiveNeighbours(
                    $this->getNeighbourCounter($grid, $i, $j)
                );

                $this->applyRuleFor($next, $cell, $i, $j);
            }
        }

        return $next;
    }

    public function getNeighbourCounter(
        array $grid,
        int $cols,
        int $rows
    ): LiveNeighbourFinderWrapAroundEdge {
        return new LiveNeighbourFinderWrapAroundEdge($grid, $cols, $rows);
    }
}
