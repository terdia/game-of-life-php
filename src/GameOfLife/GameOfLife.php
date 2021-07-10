<?php declare(strict_types=1);

namespace App\GameOfLife;

use App\GameOfLife\Config\GameConfig;

class GameOfLife
{
    private GameConfig              $config;
    private NextGenerationInterface $nextGeneration;

    public function __construct(
        GameConfig $config,
        NextGenerationInterface $nextGeneration
    ) {
        $this->config         = $config;
        $this->nextGeneration = $nextGeneration;
    }

    public function start(): void
    {
        $board     = $this->config->getBoard();
        $grid      = $board->getGrid();
        $cols      = $board->getCols();
        $rows      = $board->getRows();

        echo "****Input Generation***";
        $this->display($grid, $cols, $rows);

        echo "****Next Generations***";
        $iterations = $this->config->getIterations();
        do {
            $iterations--;
            $next = $this->nextGeneration->generate($grid, $cols, $rows);
            $this->display($next, $cols, $rows);
            $grid = $next;
        } while ($iterations > 0);
    }

    //todo: decouple to allow different display format
    private function display(array $grid, int $cols, int $rows): void
    {
        echo "<br />"; // when viweing in the browser
        //echo "\n"; // when viweing in the terminal
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
}
