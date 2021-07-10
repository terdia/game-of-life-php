<?php declare(strict_types=1);

namespace App\GameOfLife;

use App\GameOfLife\ValueObjects\CellState;

class Game
{
    private Board $board;
    private int   $circles;

    public function __construct(Board $board, int $circles)
    {
        $this->board   = $board;
        $this->circles = $circles;
    }

    public function run(): void
    {
        $grid = $this->board->getGrid();
        $cols = $this->board->getCols();
        $rows = $this->board->getRows();

        echo "****Input***";
        $this->display($grid, $cols, $rows);

        echo "****Next Generations***";
        $next = $this->getNextGeneration($grid, $cols, $rows);
        $this->display($next, $cols, $rows);

        do {
            $this->circles--;
            $next = $this->getNextGeneration($next, $cols, $rows);
            $this->display($next, $cols, $rows);
        } while ($this->circles > 0);
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

    private function getNextGeneration(array $grid, int $cols, int $rows): array
    {
        $next = $grid;
        for ($i = 0; $i < $cols; $i++) {
            for ($j = 0; $j < $rows; $j++) {
                /** @var Cell $cell */
                $cell = $grid[$i][$j];

                //count live neighbours
                $neighbours = $cell->countNeighbours($grid, $i, $j, $cols, $rows);

                if ($cell->stateShouldBeLive($neighbours)) {
                    $next[$i][$j] = new Cell(CellState::live());
                } elseif ($cell->stateShouldBeDead($neighbours)) {
                    $next[$i][$j] = new Cell(CellState::dead());
                } else {
                    $next[$i][$j] = $cell;
                }
            }
        }

        return $next;
    }

}
