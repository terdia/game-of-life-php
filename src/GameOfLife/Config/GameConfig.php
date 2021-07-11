<?php declare(strict_types=1);

namespace App\GameOfLife\Config;

use App\GameOfLife\Board;
use App\GameOfLife\NextGenerationInterface;

class GameConfig
{
    private Board                   $board;
    private NextGenerationInterface $nextGenerationAlgorithm;
    private int                     $iterations;

    public function __construct(
        Board $board,
        NextGenerationInterface $nextGenerationAlgorithm,
        int $iterations
    ) {
        $this->board                   = $board;
        $this->nextGenerationAlgorithm = $nextGenerationAlgorithm;
        $this->iterations              = $iterations;
    }

    public function getBoard(): Board
    {
        return $this->board;
    }

    public function getNextGenerationAlgorithm(): NextGenerationInterface
    {
        return $this->nextGenerationAlgorithm;
    }

    public function getIterations(): int
    {
        return $this->iterations;
    }

}
