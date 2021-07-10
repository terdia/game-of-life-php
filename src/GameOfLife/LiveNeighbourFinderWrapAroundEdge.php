<?php declare(strict_types=1);

namespace App\GameOfLife;

use function count;

class LiveNeighbourFinderWrapAroundEdge extends LiveNeighbourFinder
{

    public function countNeighbours(): int
    {
        $grid          = $this->getGrid();
        $x             = $this->getX();
        $y             = $this->getY();
        $totalCols     = count($grid);
        $totalrows     = count($grid[0] ?? []);
        $sumLiveNeighbours = 0;

        for ($i = -1; $i < 2; $i++) {
            for ($j = -1; $j < 2; $j++) {
                //wrap around the edges
                // e.g. (0 + -1 + 10) % 10 = 9; (1 + -1 + 10) % 10 = 0;
                $colIndex = ($x + $i + $totalCols) % $totalCols;
                $rowIndex = ($y + $j + $totalrows) % $totalrows;

                /** @var Cell $cell */
                $cell          = $grid[$colIndex][$rowIndex];
                $sumLiveNeighbours += $cell->isAlive() ? 1 : 0;
            }
        }

        $sumLiveNeighbours -= $grid[$x][$y]->isAlive() ? 1 : 0;

        return $sumLiveNeighbours;
    }
}
