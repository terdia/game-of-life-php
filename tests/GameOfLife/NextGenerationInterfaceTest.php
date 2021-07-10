<?php declare(strict_types=1);

namespace Tests\GameOfLife;

use App\GameOfLife\Board;
use App\GameOfLife\Config\LiveCellConfig;
use App\GameOfLife\Factory\GridFactory;
use App\GameOfLife\NextGenerationIgnoredEdge;
use App\GameOfLife\NextGenerationWrapAroundEdge;
use App\GameOfLife\ValueObjects\CellState;
use PHPUnit\Framework\TestCase;

class NextGenerationInterfaceTest extends TestCase
{

    public function testGenerateNextGenerationWrapAroundEdgeAlgo(): void
    {
        $config = [
            new LiveCellConfig(1, 4),
            new LiveCellConfig(2, 3),
            new LiveCellConfig(2, 4),
        ];
        $board  = new Board(new GridFactory(...$config), 4, 8);

        $wrapAroundEdgesAlgorithm = new NextGenerationWrapAroundEdge();
        //act
        $next = $wrapAroundEdgesAlgorithm->generate(
            $board->getGrid(),
            $board->getCols(),
            $board->getRows()
        );

        self::assertIsArray($next);
        self::assertNotEmpty($next);
        self::assertSame(CellState::IS_LIVE, $next[1][3]->getState()->value());
        self::assertSame(CellState::IS_LIVE, $next[1][4]->getState()->value());
        self::assertSame(CellState::IS_LIVE, $next[2][3]->getState()->value());
        self::assertSame(CellState::IS_LIVE, $next[2][4]->getState()->value());
    }

    public function testGenerateNextGenerationIgnoreEdgeAlgo(): void
    {
        $config = [
            new LiveCellConfig(1, 4),
            new LiveCellConfig(2, 3),
            new LiveCellConfig(2, 4),
        ];
        $board  = new Board(new GridFactory(...$config), 4, 8);

        $ignoredEdgesAlgorithm    = new NextGenerationIgnoredEdge();
        //act
        $next = $ignoredEdgesAlgorithm->generate(
            $board->getGrid(),
            $board->getCols(),
            $board->getRows()
        );

        self::assertIsArray($next);
        self::assertNotEmpty($next);
        self::assertSame(CellState::IS_LIVE, $next[1][3]->getState()->value());
        self::assertSame(CellState::IS_LIVE, $next[1][4]->getState()->value());
        self::assertSame(CellState::IS_LIVE, $next[2][3]->getState()->value());
        self::assertSame(CellState::IS_LIVE, $next[2][4]->getState()->value());
    }
}
