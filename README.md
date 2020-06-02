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

This bundle adds a command to run the snake game in your console.
It is a demo for the `cursor` added in Symfony Console 5.1.
Let it not distract you from your work ;-)

# Installation and Usage
                          
## Installation

    composer require dbu/snake-bundle

## Run

    bin/console game:snake

## Development

Clone the git repository, then run:

    composer install
    ./tests/fixtures/app/bin/console game:snake

# FAQ

## My console is looking weird after running the command

This can happen after aborting the program, e.g. with <ctrl>-c. Reset the console to sane defaults
by typing:

    stty sane

Be aware that input is probably hidden, so you won't see anything until you hit enter.

## Why Snake?

Because it was the first thing I could think of. 
And its simple enough that it should be possible to follow what is going on.

## What is this font?

Delta Corps Priest 1 from http://patorjk.com/software/taag/

# Screenshots

![start screen](snake.png)

![lost game](snake2.png)
