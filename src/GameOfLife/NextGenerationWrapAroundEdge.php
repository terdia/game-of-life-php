<?php declare(strict_types=1);

namespace App\GameOfLife;

use App\GameOfLife\ValueObjects\CellState;

class NextGenerationWrapAroundEdge implements NextGenerationInterface
{

    public function generate(array $grid, int $cols, int $rows): array
    {
        $nextWrapEdges = $grid;
        for ($i = 0; $i < $cols; $i++) {
            for ($j = 0; $j < $rows; $j++) {
                /** @var Cell $cell */
                $cell = $grid[$i][$j];
                //set live neighbours for current cell
                $cell->setTotalLiveNeighbours(
                    $this->getNeighbourCounter($grid, $i, $j)
                );

                if (!$cell->isAlive() && $cell->hasExactlyThreeLiveNeighbours()) {
                    $nextWrapEdges[$i][$j] = new Cell(CellState::live());
                } elseif (
                    $cell->isAlive()
                    && ($cell->inUnderPopuatedNeighbourHood()
                        || $cell->inOverPopuatedNeighbourHood())
                ) {
                    $nextWrapEdges[$i][$j] = new Cell(CellState::dead());
                } else {
                    $nextWrapEdges[$i][$j] = $cell;
                }
            }
        }

        return $nextWrapEdges;
    }

    public function getNeighbourCounter(
        array $grid,
        int $cols,
        int $rows
    ): LiveNeighbourFinderWrapAroundEdge {
        return new LiveNeighbourFinderWrapAroundEdge($grid, $cols, $rows);
    }
}
