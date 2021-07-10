<?php declare(strict_types=1);

namespace App\GameOfLife;

use App\GameOfLife\ValueObjects\CellState;

class NextGenerationIgnoredEdge implements NextGenerationInterface
{

    public function generate(array $grid, int $cols, int $rows): array
    {
        $next = $grid;
        for ($i = 0; $i < $cols; $i++) {
            for ($j = 0; $j < $rows; $j++) {
                /** @var Cell $cell */
                $cell = $grid[$i][$j];

                //ignore edges
                if (($i === 0) || ($i === $cols - 1) || ($j === 0) || ($j === $rows - 1)) {
                    $next[$i][$j] = $cell;
                    continue;
                }

                $cell->setTotalLiveNeighbours(
                    $this->getNeighbourCounter($grid, $i, $j)
                );

                if (!$cell->isAlive() && $cell->hasExactlyThreeLiveNeighbours()) {
                    $next[$i][$j] = new Cell(CellState::live());
                } elseif (
                    $cell->isAlive()
                    && ($cell->isInUnderPopulatedNeighbourHood()
                        || $cell->isInOverPopulatedNeighbourHood())
                ) {
                    $next[$i][$j] = new Cell(CellState::dead());
                } else {
                    $next[$i][$j] = $cell;
                }
            }
        }

        return $next;
    }

    public function getNeighbourCounter(
        array $grid,
        int $cols,
        int $rows
    ): LiveNeighbourFinderIgnoreEdge {
        return new LiveNeighbourFinderIgnoreEdge($grid, $cols, $rows);
    }
}
