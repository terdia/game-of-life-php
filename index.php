<?php declare(strict_types=1);

use App\GameOfLife\Board;
use App\GameOfLife\Config\GameConfig;
use App\GameOfLife\Factory\GridFactory;
use App\GameOfLife\GameOfLife;
use App\GameOfLife\Config\LiveCellConfig;

require_once __DIR__ . '/vendor/autoload.php';

$config = [
    new LiveCellConfig(0, 2),
    new LiveCellConfig(1, 3),
    new LiveCellConfig(2, 1),
    new LiveCellConfig(2, 2),
    new LiveCellConfig(2, 3),
];

$board = new Board(new GridFactory(...$config), 5, 6);
$grid  = $board->getGrid();
$game = new GameOfLife(new GameConfig(5, false, $board));
$game->run();


