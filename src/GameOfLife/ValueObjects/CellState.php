<?php declare(strict_types=1);

namespace App\GameOfLife\ValueObjects;

use LogicException;

/**
 * Class CellState
 *
 * provide a consistent way to set cell value,
 * a cell cab either be live or dead
 *
 * @package App\GameOfLife\ValueObjects
 */
class CellState
{
    public const  IS_LIVE = 1;
    private const DEAD    = 0;

    private int $value;

    public function __construct(int $value)
    {
        if (!in_array($value, [self::IS_LIVE, self::DEAD,], true)) {
            throw new LogicException(
                sprintf("%s is not a valid cell value", $value)
            );
        }

        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    public static function live(): CellState
    {
        return new self(self::IS_LIVE);
    }

    public static function dead(): CellState
    {
        return new self(self::DEAD);
    }
}
