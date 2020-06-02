<?php

namespace Dbu\SnakeBundle\Game;

use Symfony\Component\Console\Cursor;
use Symfony\Component\Console\Output\OutputInterface;

class Snake
{
    /**
     * @var Board
     */
    private $board;

    public const UP = 'up';
    public const RIGHT = 'right';
    public const DOWN = 'down';
    public const LEFT = 'left';

    private $direction = self::RIGHT;

    /**
     * @var Coordinate
     */
    private $head;

    /**
     * @var Coordinate[]
     */
    private $tail;

    /**
     * @var int
     */
    private $grow = 2;

    public function __construct(Board $board, Coordinate $start)
    {
        $this->board = $board;
        $this->head = clone $start;
        $this->tail = [clone $start];
    }

    public function setDirection(string $direction): void
    {
        if (self::UP === $this->direction && self::DOWN === $direction
            || self::DOWN === $this->direction && self::UP === $direction
            || self::LEFT === $this->direction && self::RIGHT === $direction
            || self::RIGHT === $this->direction && self::LEFT === $direction
        ) {
            // ignore direction reversal which would lead to immediate self-collision
            return;
        }
        $this->direction = $direction;
    }

    public function tick(OutputInterface $output, Cursor $cursor): void
    {
        switch ($this->direction) {
            case self::UP:
                $this->head->y--;
                break;
            case self::RIGHT:
                $this->head->x++;
                break;
            case self::DOWN:
                $this->head->y++;
                break;
            case self::LEFT:
                $this->head->x--;
                break;
        }

        $this->grow += $this->board->enter($this->head);

        $cursor->moveToPosition($this->head->x, $this->head->y);
        $output->write('<snake>█</snake>');
        $this->tail[] = clone $this->head;
        if ($this->grow > 0) {
            $this->grow--;
        } else {
            $coord = array_shift($this->tail);
            $this->board->leave($coord);
            $cursor->moveToPosition($coord->x, $coord->y);
            $output->write('<background> </background>');
        }
    }

    public function addGrow(int $amount): void
    {
        $this->grow += $amount;
    }
}
