<?php

namespace Dbu\SnakeBundle\Game;

use Throwable;

class CollisionException extends \RuntimeException
{
    private $coordinate;

    public function __construct(Coordinate $coord)
    {
        parent::__construct(sprintf('Collision at %s/%s', $coord->x, $coord->y));

        $this->coordinate = $coord;
    }

    public function getCoordinate(): Coordinate
    {
        return $this->coordinate;
    }
}
