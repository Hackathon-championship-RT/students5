<?php

declare(strict_types=1);

namespace App\Helper;

class Tile
{
    public int $x;
    public int $y;
    public int $z;
    public int $t;

    public function assignFromArray(array $array): static
    {
        $this->x = $array[0];
        $this->y = $array[1];
        $this->z = $array[2];
        $this->t = $array[3];

        return $this;
    }

    public function assignFromAssocArray(array $array): static
    {
        $this->x = $array['x'];
        $this->y = $array['y'];
        $this->z = $array['z'];
        $this->t = $array['t'];

        return $this;
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
