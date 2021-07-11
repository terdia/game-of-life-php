<?php declare(strict_types=1);

use App\GameOfLife\Board;
use App\GameOfLife\Config\GameConfig;
use App\GameOfLife\Factory\GridFactory;
use App\GameOfLife\GameOfLife;
use App\GameOfLife\Config\LiveCell;
use App\GameOfLife\NextGenerationIgnoredEdge;
use App\GameOfLife\NextGenerationWrapAroundEdge;

require_once __DIR__ . '/vendor/autoload.php';

/*$liveCells = [
    new LiveCell(1, 4),
    new LiveCell(2, 3),
    new LiveCell(2, 4),
];
*/
//4, 8

//$ignoredEdgesAlgorithm    = new NextGenerationIgnoredEdge();

$liveCells = [
    new LiveCell(0, 2),
    new LiveCell(1, 3),
    new LiveCell(2, 1),
    new LiveCell(2, 2),
    new LiveCell(2, 3),
];

$wrapAroundEdgesAlgorithm = new NextGenerationWrapAroundEdge();
$board                    = new Board(new GridFactory(...$liveCells), 5, 6);

$iterations = 5;
$gameConfig = new GameConfig(
    $board,
    $wrapAroundEdgesAlgorithm,
    $iterations
);

(new GameOfLife($gameConfig))->start();



