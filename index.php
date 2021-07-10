<?php declare(strict_types=1);

use App\GameOfLife\Board;
use App\GameOfLife\Config\GameConfig;
use App\GameOfLife\Factory\GridFactory;
use App\GameOfLife\GameOfLife;
use App\GameOfLife\Config\LiveCellConfig;
use App\GameOfLife\NextGenerationIgnoredEdge;
use App\GameOfLife\NextGenerationWrapAroundEdge;

require_once __DIR__ . '/vendor/autoload.php';

/*$configTwo = [
    new LiveCellConfig(1, 4),
    new LiveCellConfig(2, 3),
    new LiveCellConfig(2, 4),
];
*/
//4, 8

//$ignoredEdgesAlgorithm    = new NextGenerationIgnoredEdge();

$config = [
    new LiveCellConfig(0, 2),
    new LiveCellConfig(1, 3),
    new LiveCellConfig(2, 1),
    new LiveCellConfig(2, 2),
    new LiveCellConfig(2, 3),
];

$wrapAroundEdgesAlgorithm = new NextGenerationWrapAroundEdge();
$board                    = new Board(new GridFactory(...$config), 5, 6);

$iterations = 5;
$game       = new GameOfLife(
    new GameConfig($iterations, $board),
    $wrapAroundEdgesAlgorithm
);
$game->start();


