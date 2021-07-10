<?php declare(strict_types=1);

namespace App\GameOfLife;

use App\GameOfLife\ValueObjects\CellState;

class Cell
{
    private CellState $state;

    public function __construct(CellState $state)
    {
        $this->state = $state;
    }

    public function getState(): CellState
    {
        return $this->state;
    }

    public function stateShouldBeDead(int $neighbours): bool
    {
        return (1 === $this->state->value() && ($neighbours < 2 || $neighbours > 3));
    }

    public function stateShouldBeLive(int $neighbours): bool
    {
        return 0 === $this->state->value() && $neighbours === 3;
    }

    public function countNeighbours(array $grid, int $x, int $y, int $cols, int $rows): int
    {
        $total = 0;
        for ($i = -1; $i < 2; $i++) {
            for ($j = -1; $j < 2; $j++) {
                //wrap around the edges
                $colIndex = ($x + $i + $cols) % $cols;
                $rowIndex = ($y + $j + $rows) % $rows;

                /** @var Cell $cell */
                $cell  = $grid[$colIndex][$rowIndex];
                $total += $cell->getState()->value();
            }
        }

        $total -= $grid[$x][$y]->getState()->value();

        return $total;
    }

}
