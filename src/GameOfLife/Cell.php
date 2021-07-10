<?php declare(strict_types=1);

namespace App\GameOfLife;

use App\GameOfLife\ValueObjects\CellState;

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

    public function setTotalLiveNeighbours(LiveNeighbourFinder $neighbourFinder): void
    {
        $this->totalLiveNeighbours = $neighbourFinder->countNeighbours();
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
}
