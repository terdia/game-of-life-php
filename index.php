<?php declare(strict_types=1);

use App\GameOfLife\Board;
use App\GameOfLife\Factory\GridFactory;
use App\GameOfLife\Game;
use App\GameOfLife\LiveCellConfig;

require_once __DIR__ . '/vendor/autoload.php';

$config = [
    new LiveCellConfig(0, 2),
    new LiveCellConfig(1, 3),
    new LiveCellConfig(2, 1),
    new LiveCellConfig(2, 2),
    new LiveCellConfig(2, 3),
];

$board = new Board(new GridFactory(...$config), 4, 5);
$game  = new Game($board, 5);
$game->run();


