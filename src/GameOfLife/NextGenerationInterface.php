<?php declare(strict_types=1);

namespace App\GameOfLife;

interface NextGenerationInterface
{
    public function generate(array $grid, int $cols, int $rows): array;

    public function getNeighbourCounter(
        array $grid,
        int $cols,
        int $rows
    ): LiveNeighbourFinder;

    public function applyRuleFor(array &$next, Cell $cell, int $x, int $y): void;
}
