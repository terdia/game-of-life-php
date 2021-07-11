<?php declare(strict_types=1);

namespace App\GameOfLife;

use App\GameOfLife\ValueObjects\CellState;

trait RuleApplier
{
    public function applyRuleFor(array &$next, Cell $cell, int $x, int $y): void
    {
        if (!$cell->isAlive() && $cell->hasExactlyThreeLiveNeighbours()) {
            $next[$x][$y] = new Cell(CellState::live());
        } elseif (
            $cell->isAlive()
            && ($cell->isInUnderPopulatedNeighbourHood()
                || $cell->isInOverPopulatedNeighbourHood())
        ) {
            $next[$x][$y] = new Cell(CellState::dead());
        } else {
            $next[$x][$y] = $cell;
        }
    }
}
