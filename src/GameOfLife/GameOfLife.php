<?php declare(strict_types=1);

namespace App\GameOfLife;

use App\GameOfLife\Config\GameConfig;

class GameOfLife
{
    private GameConfig              $config;

    public function __construct(GameConfig $config)
    {
        $this->config = $config;
    }

    public function start(): void
    {
        $algorithm = $this->config->getNextGenerationAlgorithm();
        $board     = $this->config->getBoard();
        $grid      = $board->getGrid();
        $cols      = $board->getCols();
        $rows      = $board->getRows();
        $iterations = $this->config->getIterations();

        echo "****Input Generation***";
        $this->display($grid, $cols, $rows);

        echo "****Next Generations***";
        do {
            $iterations--;
            $next = $algorithm->generate($grid, $cols, $rows);
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
