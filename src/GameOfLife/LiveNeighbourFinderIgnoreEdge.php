<?php declare(strict_types=1);

namespace App\GameOfLife;

class LiveNeighbourFinderIgnoreEdge extends LiveNeighbourFinder
{

    public function countLiveNeighbours(): int
    {
        $grid          = $this->getGrid();
        $x             = $this->getX();
        $y             = $this->getY();
        $sumLiveNeighbours = 0;

        for ($i = -1; $i < 2; $i++) {
            for ($j = -1; $j < 2; $j++) {
                /** @var Cell $cell */
                $cell          = $grid[$x + $i][$y + $j];
                $sumLiveNeighbours += $cell->isAlive() ? 1 : 0;
            }
        }

        $sumLiveNeighbours -= $grid[$x][$y]->isAlive() ? 1 : 0;

        return $sumLiveNeighbours;
    }
}
