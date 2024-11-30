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

    public static function setCanClick(array $board): void
    {
        foreach ($board as $tile) {
            $upperTiles = array_filter($board, static function ($item) use ($tile) {
                if (
                    $item->getZ() === $tile->getZ() + 1
                    && abs($item->getX() - $tile->getX()) < 2
                    && abs($item->getY() - $tile->getY()) < 2
                ) {
                    return $item;
                }
                return null;
            }
            );

            $leftTiles = array_filter($board, static function ($item) use ($tile) {
                if (
                    $item->getX() === $tile->getX() + 2
                    && $item->getZ() === $tile->getZ()
                    && abs($item->getY() - $tile->getY()) < 2
                ) {
                    return $item;
                }
                return null;
            }
            );

            $rightTiles = array_filter($board, static function ($item) use ($tile) {
                if (
                    $item->getX() === $tile->getX() - 2
                    && $item->getZ() === $tile->getZ()
                    && abs($item->getY() - $tile->getY()) < 2
                ) {
                    return $item;
                }
                return null;
            }
            );

            if (count($upperTiles) > 0 || (count($leftTiles) > 0 && count($rightTiles) > 0)) {
                $tile->setCanClick(false);
            }
        }
    }

    public static function getMatchCount(array $board): int
    {
        $cnt = 0;
        $tileTypes = array_unique(array_map(fn($item) => $item->getT(), $board));
        foreach ($tileTypes as $tileType) {
            $tiles = array_filter($board, static function ($item) use ($tileType) {
                if ($item->getT() === $tileType && $item->getCanClick()) {
                    return $item;
                }
                return null;
            });

            $cnt += (int)(count($tiles) / 2);
        }
        return $cnt;
    }
}
