<?php

declare(strict_types=1);

namespace App\Helper;

class BoardHelper
{
    public static function generateBoard(): array
    {
        return [
            (new Tile())->assignFromArray([0, 0, 0, 1]),
            (new Tile())->assignFromArray([2, 0, 0, 2]),
            (new Tile())->assignFromArray([4, 0, 0, 1]),
            (new Tile())->assignFromArray([6, 0, 0, 2]),
            (new Tile())->assignFromArray([1, 0, 1, 3]),
            (new Tile())->assignFromArray([5, 0, 1, 3])
        ];
    }
}
