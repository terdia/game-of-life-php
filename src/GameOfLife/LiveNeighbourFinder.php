<?php declare(strict_types=1);

namespace App\GameOfLife;

abstract class LiveNeighbourFinder
{
    private array $grid;
    private int   $x;
    private int   $y;

    public function __construct(array $grid, int $x, int $y)
    {
        $this->grid = $grid;
        $this->x    = $x;
        $this->y    = $y;
    }

    public function getGrid(): array
    {
        return $this->grid;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    abstract public function countNeighbours(): int;
}
