                                 /^\/^\
                               _|__|  O|
                      \/     /~     \_/ \
                       \____|__________/  \
                             \_______      \
                                     `\     \                    \
                                      |     |                     \
     ____              _             /     /                       \
    / ___| _ __   __ _| | _____     /     /                         \\
    \___ \| '_ \ / _` | |/ / _ \   /     /                           \ \
     ___) | | | | (_| |   <  __/  /     /                             \  \
    |____/|_| |_|\__,_|_|\_\___| /     /             _----_            \   \
                                /     /           _-~      ~-_         |   |
                               (      (        _-~    _--_    ~-_     _/   |
                                \      ~-____-~    _-~    ~-_    ~-_-~    /
                                  ~-_           _-~          ~-_       _-~   - jurcy -
                                     ~--______-~                ~-___-~

Symfony bundle for `dbu/php-snake`, the command line snake game.

This repository provides the bundle to install in a Symfony application. If you just want the game stand-alone, look at
the [php-snake](https://github.com/dbu/php-snake) repository.

# Installation and Usage

## Installation

In your Symfony application, run:

    composer require dbu/snake-bundle

## Run

    bin/console game:snake

## Development

Clone the git repository, then run:

    composer install
    ./tests/fixtures/app/bin/console game:snake

# Screenshots

![start screen](snake.png)
