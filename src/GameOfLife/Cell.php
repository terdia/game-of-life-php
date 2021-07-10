<?php declare(strict_types=1);

namespace App\GameOfLife;

use App\GameOfLife\ValueObjects\CellState;

use function count;

class Cell
{
    private CellState $state;
    private int       $totalLiveNeighbours = 0;

    public function __construct(CellState $state)
    {
        $this->state = $state;
    }

    public function getState(): CellState
    {
        return $this->state;
    }

    public function isAlive(): bool
    {
        return $this->state->value() === CellState::IS_LIVE;
    }

    public function inOverPopuatedNeighbourHood(): bool
    {
        return $this->totalLiveNeighbours > 3;
    }

    public function inUnderPopuatedNeighbourHood(): bool
    {
        return $this->totalLiveNeighbours < 2;
    }

    public function hasExactlyThreeLiveNeighbours(): bool
    {
        return $this->totalLiveNeighbours === 3;
    }

    public function getTotalLiveNeighbours(): int
    {
        return $this->totalLiveNeighbours;
    }

    public function setTotalLiveNeighboursWrapEdges(array $grid, int $x, int $y): void
    {
        $colCount = count($grid);
        $rowCount = count($grid[0] ?? []);

        for ($i = -1; $i < 2; $i++) {
            for ($j = -1; $j < 2; $j++) {
                //wrap around the edges
                // e.g. (0 + -1 + 10) % 10 = 9; (4 + 1 + 10) % 10 = 5
                $colIndex = ($x + $i + $colCount) % $colCount;
                $rowIndex = ($y + $j + $rowCount) % $rowCount;

                /** @var Cell $cell */
                $cell                      = $grid[$colIndex][$rowIndex];
                $this->totalLiveNeighbours += $cell->isAlive() ? 1 : 0;
            }
        }

        $this->totalLiveNeighbours -= $grid[$x][$y]->isAlive() ? 1 : 0;
    }

    public function setTotalLiveNeighboursEdgesIgnored(array $grid, int $x, int $y): void
    {
        for ($i = -1; $i < 2; $i++) {
            for ($j = -1; $j < 2; $j++) {
                /** @var Cell $cell */
                $cell                      = $grid[$x + $i][$y + $j];
                $this->totalLiveNeighbours += $cell->isAlive() ? 1 : 0;
            }
        }

        $this->totalLiveNeighbours -= $grid[$x][$y]->isAlive() ? 1 : 0;
    }
}
