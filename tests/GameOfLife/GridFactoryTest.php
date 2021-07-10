<?php declare(strict_types=1);

namespace Tests\GameOfLife;

use App\GameOfLife\Factory\GridFactory;
use PHPUnit\Framework\TestCase;

class GridFactoryTest extends TestCase
{

    public function testItMakesATwoDimensionalGridOfGivenColumnsAndRows(): void
    {
        $factory = new GridFactory(null);
        $cols    = 8;
        $rows    = 10;

        $grid = $factory->make($cols, $rows);

        self::assertIsArray($grid);
        self::assertCount($cols, $grid);
        self::assertCount($rows, $grid[0]);
    }
}
