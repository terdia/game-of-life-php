<?php declare(strict_types=1);

namespace App\GameOfLife;

use App\GameOfLife\Config\GameConfig;
use App\GameOfLife\ValueObjects\CellState;

class GameOfLife
{
    private GameConfig $config;

    public function __construct(GameConfig $config)
    {
        $this->config = $config;
    }

    public function run(): void
    {
        $board     = $this->config->getBoard();
        $grid      = $board->getGrid();
        $cols      = $board->getCols();
        $rows      = $board->getRows();
        $wrapEdges = $this->config->shouldWrapEdges();

        echo "****Input Generation***";
        $this->display($grid, $cols, $rows);

        echo "****Next Generations***";
        $next = $this->computeNextGen($grid, $cols, $rows, $wrapEdges);
        $this->display($next, $cols, $rows);

        $iterations = $this->config->getIterations();
        do {
            $iterations--;
            $next = $this->computeNextGen($next, $cols, $rows, $wrapEdges);
            $this->display($next, $cols, $rows);
        } while ($iterations > 0);
    }

    private function display(array $grid, int $cols, int $rows): void
    {
        echo "<br />";
        //echo "\n";
        for ($i = 0; $i < $cols; $i++) {
            for ($j = 0; $j < $rows; $j++) {
                /** @var Cell $cell */
                $cell = $grid[$i][$j];
                echo $cell->getState()->value() . ' ';
            }
            //echo "\n";
            echo "<br />";
        }
    }

    private function getNextGenerationWrapEdges(array $grid, int $cols, int $rows): array
    {
        $nextWrapEdges = $grid;
        for ($i = 0; $i < $cols; $i++) {
            for ($j = 0; $j < $rows; $j++) {
                /** @var Cell $cell */
                $cell = $grid[$i][$j];
                //set live neighbours for current cell
                $cell->setTotalLiveNeighboursWrapEdges($grid, $i, $j);

                if (!$cell->isAlive() && $cell->hasExactlyThreeLiveNeighbours()) {
                    $nextWrapEdges[$i][$j] = new Cell(CellState::live());
                } elseif (
                    $cell->isAlive()
                    && ($cell->inUnderPopuatedNeighbourHood()
                        || $cell->inOverPopuatedNeighbourHood())
                ) {
                    $nextWrapEdges[$i][$j] = new Cell(CellState::dead());
                } else {
                    $nextWrapEdges[$i][$j] = $cell;
                }
            }
        }

        return $nextWrapEdges;
    }

    private function getNextGenerationIgnoreEdges(array $grid, int $cols, int $rows): array
    {
        $next = $grid;
        for ($i = 0; $i < $cols; $i++) {
            for ($j = 0; $j < $rows; $j++) {
                /** @var Cell $cell */
                $cell = $grid[$i][$j];

                //ignore edges
                if (($i === 0) || ($i === $cols - 1) || ($j === 0) || ($j === $rows - 1)) {
                    $next[$i][$j] = $cell;
                    continue;
                }

                $cell->setTotalLiveNeighboursEdgesIgnored($grid, $i, $j);

                if (!$cell->isAlive() && $cell->hasExactlyThreeLiveNeighbours()) {
                    $next[$i][$j] = new Cell(CellState::live());
                } elseif (
                    $cell->isAlive()
                    && ($cell->inUnderPopuatedNeighbourHood()
                        || $cell->inOverPopuatedNeighbourHood())
                ) {
                    $next[$i][$j] = new Cell(CellState::dead());
                } else {
                    $next[$i][$j] = $cell;
                }
            }
        }

        return $next;
    }

    private function computeNextGen(array $grid, int $cols, int $rows, bool $wrapEdges): array
    {
        if ($wrapEdges) {
            return $this->getNextGenerationWrapEdges($grid, $cols, $rows);
        }

        return $this->getNextGenerationIgnoreEdges($grid, $cols, $rows);
    }
}
