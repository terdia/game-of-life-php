<?php declare(strict_types=1);

namespace App\GameOfLife\Factory;

use App\GameOfLife\Cell;
use App\GameOfLife\Config\LiveCellConfig;
use App\GameOfLife\ValueObjects\CellState;

use function array_fill;
use function array_filter;
use function count;
use function random_int;

class GridFactory
{
    private array $liveCellConfigs;

    public function __construct(?LiveCellConfig ...$liveCellConfigs)
    {
        $this->liveCellConfigs = array_filter($liveCellConfigs);
    }

    public function make(int $cols, int $rows): array
    {
        $grid = array_fill(0, $cols, null);
        for ($i = 0; $i < $cols; $i++) {
            $grid[$i] = array_fill(0, $rows, new Cell(CellState::dead()));
        }

        if (0 < count($this->liveCellConfigs)) {
            /** @var LiveCellConfig $config */
            foreach ($this->liveCellConfigs as $config) {
                $row      = $config->getRow();
                $position = $config->getPosition();
                if (isset($grid[$row][$position])) {
                    $grid[$row][$position] = new Cell(CellState::live());
                }
            }
        } else {
            $this->fillCellsWithRandomState($grid, $cols, $rows);
        }

        return $grid;
    }

    private function fillCellsWithRandomState(array &$grid, int $cols, int $rows): void
    {
        for ($i = 0; $i < $cols; $i++) {
            for ($j = 0; $j < $rows; $j++) {
                $grid[$i][$j] = new Cell(new CellState(random_int(0, 1)));
            }
        }
    }

}
