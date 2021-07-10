<?php declare(strict_types=1);

namespace App\GameOfLife\Config;

use App\GameOfLife\Board;

class GameConfig
{
    private int   $iterations;
    private bool  $wrapEdges;
    private Board $board;

    public function __construct(int $iterations, bool $wrapEdges, Board $board)
    {
        $this->iterations = $iterations;
        $this->wrapEdges  = $wrapEdges;
        $this->board      = $board;
    }

    public function getIterations(): int
    {
        return $this->iterations;
    }

    public function shouldWrapEdges(): bool
    {
        return $this->wrapEdges;
    }

    public function getBoard(): Board
    {
        return $this->board;
    }
}
