<?php


namespace Dbu\SnakeBundle\Game;


use Symfony\Component\Console\Cursor;
use Symfony\Component\Console\Output\OutputInterface;

class Board
{
    private const GROWTH_RATE = 6;

    /**
     * @var int
     */
    private $score = 0;

    private $board;
    private $width;
    private $height;

    /**
     * @var Snake
     */
    private $snake;

    /**
     * @var Coordinate
     */
    private $goal;

    /**
     * @var bool
     */
    private $newGoal;

    public function __construct(int $width, int $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function addSnake(Snake $snake): void
    {
        $this->snake = $snake;
    }

    public function init(OutputInterface $output, Cursor $cursor): void
    {
        $this->board = [];
        for ($i = 0; $i < $this->width; $i++) {
            $this->board[$i] = array_fill(0, $this->height, 0);
        }
        $cursor->clearScreen();
        $cursor->moveToPosition(0,0);

        $output->writeln('<background>┌──────────────────────────────────────────────────────────────────────────────┐</background>');
        for ($i = 0; $i < $this->height - 2; $i++) {
        $output->writeln('<background>│                                                                              │</background>');
        }
        $output->writeln('<background>└──────────────────────────────────────────────────────────────────────────────┘</background>');

        $this->createGoal();
    }

    public function print(OutputInterface $output, Cursor $cursor, string $lines, Coordinate $topLeft, string $font = 'background'): void
    {
        $y = $topLeft->y;
        foreach (explode("\n", $lines) as $line) {
            $cursor->moveToPosition($topLeft->x, $y++);
            $output->write("<$font>$line</$font>");
        }
    }

    public function tick(OutputInterface $output, Cursor $cursor): void
    {
        if ($this->newGoal) {
            $cursor->moveToPosition($this->goal->x, $this->goal->y);
            $output->write('<goal>*</goal>');
            $this->newGoal = false;
        }
        $this->snake->tick($output, $cursor);
    }

    public function enter(Coordinate $coordinate): int
    {
        if (!$this->allowed($coordinate)) {
            throw new CollisionException($coordinate);
        }
        $this->board[$coordinate->x][$coordinate->y] = 1;

        if ($coordinate->equals($this->goal)) {
            $this->createGoal();
            $this->score++;

            return self::GROWTH_RATE;
        }

        return 0;
    }

    public function leave(Coordinate $coordinate): void
    {
        $this->board[$coordinate->x][$coordinate->y] = 0;
    }

    public function allowed(Coordinate $coordinate): bool
    {
        if ($coordinate->x <= 1 || $coordinate->y < 1 || $coordinate->x >= $this->width || $coordinate->y >= $this->height - 1) {
            return false;
        }
        if (1 === $this->board[$coordinate->x][$coordinate->y]) {
            return false;
        }

        return true;
    }

    private function createGoal(): void
    {
        do {
            $this->goal = new Coordinate(random_int(1, $this->width-1), random_int(1, $this->height-1));
        } while (!$this->allowed($this->goal));

        $this->newGoal = true;

    }
}
