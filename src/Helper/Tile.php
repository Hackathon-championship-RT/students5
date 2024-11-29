<?php

declare(strict_types=1);

namespace App\Helper;

class Tile
{
    public int $x;
    public int $y;
    public int $z;
    public int $t;

    public function __construct(
        int $x,
        int $y,
        int $z,
        int $t,
    )
    {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
        $this->t = $t;
    }

    /**
     * @param int $t
     */
    public function setT(int $t): void
    {
        $this->t = $t;
    }

    public function setX(int $x): void
    {
        $this->x = $x;
    }

    public function setY(int $y): void
    {
        $this->y = $y;
    }

    public function setZ(int $z): void
    {
        $this->z = $z;
    }
}
