<?php

declare(strict_types=1);

namespace App\Helper;

class BoardHelper
{
    public static function generateBoard(): array
    {
        return [
            new Tile(0, 0, 0, 1),
            new Tile(2, 0, 0, 2),
            new Tile(4, 0, 0, 1),
            new Tile(6, 0, 0, 2),
            new Tile(1, 0, 1, 3),
            new Tile(5, 0, 1, 3)
        ];
    }
}
