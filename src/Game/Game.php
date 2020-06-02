<?php

namespace Dbu\SnakeBundle\Game;

use Symfony\Component\Console\Cursor;
use Symfony\Component\Console\Output\OutputInterface;

class Game
{
    /**
     * Seconds to wait between moving the head
     */
    private const TICK_DURATION = 0.2;

    private const DIRECTIONS = [
        '61' => Snake::LEFT, // a
        '73' => Snake::DOWN, // s
        '64' => Snake::RIGHT, // d
        '77' => Snake::UP, // w
        '1b5b44' => Snake::LEFT, // left arrow
        '1b5b42' => Snake::DOWN, // down arrow
        '1b5b43' => Snake::RIGHT, // right arrow
        '1b5b41' => Snake::UP, // up arrow
    ];

    /**
     * @var Board
     */
    private $board;

    /**
     * @var Snake
     */
    private $snake;

    /**
     * @var int
     */
    private $height;

    public function __construct(int $width, int $height)
    {
        $this->board = new Board($width, $height);
        $this->snake = new Snake($this->board, new Coordinate(40, 12));
        $this->board->addSnake($this->snake);
        $this->height = $height;
    }

    public function run($inputStream, OutputInterface $output, Cursor $cursor): void
    {
        $this->board->init($output, $cursor);
        $this->intro($inputStream, $output, $cursor);

        while (1) {
            $now = microtime(true);
            $next = bin2hex(fread($inputStream, 3));
            if (array_key_exists($next, self::DIRECTIONS)) {
                $this->snake->setDirection(self::DIRECTIONS[$next]);
            }
            try {
                $this->board->tick($output, $cursor);
            } catch (CollisionException $e) {
                $cursor->moveToPosition($e->getCoordinate()->x, $e->getCoordinate()->y);
                $output->write('<crash>█</crash>');

                $y = ($e->getCoordinate()->y > 7 && $e->getCoordinate()->y < 14) ? 16 : 8;
                $this->board->print($output, $cursor, Images::GAMEOVER, new Coordinate(9, $y), 'crash');

                $cursor->moveToPosition(0, $this->height+1);

                return;
            }

            $cursor->moveToPosition(0, $this->height);
            $output->write(' Score: '.$this->board->getScore());

            $speedup = min(1, $this->board->getScore() / 10);

            $tickDuration = self::TICK_DURATION - self::TICK_DURATION/2 * $speedup;
            $leftover = $tickDuration - (microtime(true) - $now);
            if ($leftover > 0) {
                usleep($leftover*1000000);
            }
        }
    }

    private function intro($inputStream, OutputInterface $output, Cursor $cursor): void
    {
        $this->board->print($output, $cursor, Images::SNAKE, new Coordinate(10, 6), 'snake');

        $this->board->print($output, $cursor, 'Use arrow keys, or a for left, s for down, d for right and w for up.', new Coordinate(7, 17));
        $this->board->print($output, $cursor, '--- Press any key to start ---', new Coordinate(25, 19));

        while (!$next = fread($inputStream, 1)) {usleep(1000);}

        for ($i = 6; $i < 18; $i += 2) {
            $this->board->print($output, $cursor, '                                                                              ', new Coordinate(2, $i));
            usleep(200000);
        }

        for ($i = 7; $i < 17; $i += 2) {
            $this->board->print($output, $cursor, '                                                                              ', new Coordinate(2, $i));
            usleep(200000);
        }
        $this->board->print($output, $cursor, '                                                                              ', new Coordinate(2, 17));
        $this->board->print($output, $cursor, '                                                                              ', new Coordinate(2, 19));

        sleep(1);
    }
}
