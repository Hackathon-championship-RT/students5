<?php

declare(strict_types=1);

namespace App\Helper;

class BoardHelper
{

    public static function generateBoard(int $tileTypes): array
    {
        $board = [];

        // Список всех плиток
        $tiles = [];
        foreach (range(1, $tileTypes) as $type) {
            $tiles = array_merge($tiles, array_fill(0, 4, $type)); // 4 плитки каждого типа
        }
        shuffle($tiles); // Перемешиваем плитки

        // 1. Первый слой (6x6)
        $baseWidth = 6;
        $baseHeight = 6;
        $board = array_merge($board, BoardHelper::fillLayer(0, $baseWidth, $baseHeight, $tiles));

        // 2. Второй слой (4x4)
        $baseWidth = 4;
        $baseHeight = 4;
        $board = array_merge($board, BoardHelper::fillLayer(1, $baseWidth, $baseHeight, $tiles, 2));

        // 3. Третий слой (2x2)
        $baseWidth = 2;
        $baseHeight = 2;
    $board = array_merge($board, BoardHelper::fillLayer(2, $baseWidth, $baseHeight, $tiles, 4));

        // 4. Четвертый слой (2 плитки по диагонали)
        $board[] = (new Tile())->assignFromArray([4, 4, 3, array_shift($tiles)]);
        $board[] = (new Tile())->assignFromArray([6, 6, 3, array_shift($tiles)]);

        return $board;
    }

// Вспомогательная функция для заполнения слоя

    public static function shuffleTileTypes(array $board): array
    {
        // Извлекаем все типы плиток
        $tileTypes = array_map(fn($tile) => $tile->getT(), $board);

        // Перемешиваем типы
        shuffle($tileTypes);

        // Назначаем перемешанные типы обратно плиткам
        foreach ($board as $index => $tile) {
            $tile->setT($tileTypes[$index]);
        }

        return $board;
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

    public static function fillLayer(int $z, int $width, int $height, array &$tiles, int $offset = 0): array
    {
        $layer = [];
        for ($y = 0; $y < $height; $y += 2) {
            for ($x = 0; $x < $width; $x += 2) {
                if (empty($tiles)) {
                    break; // Если плиток больше нет, выходим
                }

                // Добавляем плитку в слой
                $layer[] = (new Tile())->assignFromArray([
                    $x + $offset, // Учитываем смещение
                    $y + $offset, // Учитываем смещение
                    $z,           // Текущий слой
                    array_shift($tiles) // Забираем плитку
                ]);
            }
        }
        return $layer;
    }
}
