<?php declare(strict_types=1);

namespace Tests\GameOfLife;

use App\GameOfLife\Cell;
use App\GameOfLife\Config\LiveCellConfig;
use App\GameOfLife\Factory\GridFactory;
use App\GameOfLife\LiveNeighbourFinderIgnoreEdge;
use App\GameOfLife\LiveNeighbourFinderWrapAroundEdge;
use PHPUnit\Framework\TestCase;

class LiveNeighbourFinderTest extends TestCase
{

    public function testItHasExactlyThreeLiveNeighbours(): void
    {
        $config = [
            new LiveCellConfig(1, 4),
            new LiveCellConfig(2, 3),
            new LiveCellConfig(2, 4),
        ];

        $factory = new GridFactory(...$config);
        $grid    = $factory->make(4, 8);

        $finder = new LiveNeighbourFinderWrapAroundEdge(
            $grid, 1, 3
        );

        $liveNeighbours = $finder->countNeighbours();
        self::assertSame(3, $liveNeighbours);

        /** @var Cell $cell */
        $cell = $grid[1][3];
        $cell->setTotalLiveNeighbours($finder);
        self::assertTrue($cell->hasExactlyThreeLiveNeighbours());
    }

    public function testItHasMoreThanThreeLiveNeighbours(): void
    {
        $config = [
            new LiveCellConfig(0, 2),
            new LiveCellConfig(0, 4),
            new LiveCellConfig(0, 7),
            new LiveCellConfig(1, 0),
            new LiveCellConfig(1, 1),
            new LiveCellConfig(1, 2),
            new LiveCellConfig(1, 6),
            new LiveCellConfig(1, 7),
            new LiveCellConfig(2, 1),
            new LiveCellConfig(2, 2),
            new LiveCellConfig(2, 7),
        ];
        $factory = new GridFactory(...$config);
        $grid    = $factory->make(4, 8);

        $finder = new LiveNeighbourFinderIgnoreEdge(
            $grid, 1, 1
        );

        $liveNeighbours = $finder->countNeighbours();
        self::assertGreaterThan(3, $liveNeighbours);

        /** @var Cell $cell */
        $cell = $grid[1][1];
        $cell->setTotalLiveNeighbours($finder);
        self::assertTrue($cell->isInOverPopulatedNeighbourHood());
    }

    public function testItHasLessThanTwoLiveNeighbours(): void
    {
        $config = [
            new LiveCellConfig(1, 4),
            new LiveCellConfig(2, 3),
            new LiveCellConfig(2, 4),
        ];
        $factory = new GridFactory(...$config);
        $grid    = $factory->make(4, 8);

        $finder = new LiveNeighbourFinderIgnoreEdge(
            $grid, 2, 6
        );

        $liveNeighbours = $finder->countNeighbours();
        self::assertLessThan(2, $liveNeighbours);

        /** @var Cell $cell */
        $cell = $grid[2][6];
        $cell->setTotalLiveNeighbours($finder);
        self::assertTrue($cell->isInUnderPopulatedNeighbourHood());
    }
}
