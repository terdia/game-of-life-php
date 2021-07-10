<?php declare(strict_types=1);

namespace App\GameOfLife\Config;

use App\GameOfLife\Board;

class GameConfig
{
    private int   $iterations;
    private Board $board;

    public function __construct(int $iterations, Board $board)
    {
        $this->iterations = $iterations;
        $this->board      = $board;
    }

    public function getIterations(): int
    {
        return $this->iterations;
    }

    public function getBoard(): Board
    {
        return $this->board;
    }
}
