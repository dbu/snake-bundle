<?php

namespace Dbu\SnakeBundle\Game;

class Coordinate
{
    public $x;

    public $y;

    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function equals(Coordinate $goal): bool
    {
        return $goal->x === $this->x && $goal->y === $this->y;
    }
}
