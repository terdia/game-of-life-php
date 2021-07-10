<?php declare(strict_types=1);

namespace App\GameOfLife;

/**
 * Class LiveCellConfig
 *
 * provides an oop way to make a specific row->cell alive in the grid
 *
 * @package App\GameOfLife
 */
class LiveCellConfig
{
    private int   $row;
    private int   $position;

    public function __construct(int $row, int $position)
    {
        $this->row      = $row;
        $this->position = $position;
    }

    public function getRow(): int
    {
        return $this->row;
    }

    public function getPosition(): int
    {
        return $this->position;
    }
}
