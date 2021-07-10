<?php declare(strict_types=1);

namespace App\GameOfLife;

use App\GameOfLife\Factory\GridFactory;

class Board
{
    private array       $grid;
    private int         $cols;
    private int         $rows;

    public function __construct(GridFactory $gridFactory, int $cols, int $rows)
    {
        $this->grid = $gridFactory->make($cols, $rows);
        $this->cols = $cols;
        $this->rows = $rows;
    }

    public function getCols(): int
    {
        return $this->cols;
    }

    public function getRows(): int
    {
        return $this->rows;
    }

    public function getGrid(): array
    {
        return $this->grid;
    }
}
