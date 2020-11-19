<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class BowlingCommand extends Command {

    protected static $defaultName = 'bowling:get-score';

    private $frames;

    private $score;

    private $rolls = [];

    private $points = [0];

    public function __construct() {
        parent::__construct();
    }

    protected function configure(): void {
        $this->setDescription('Start a new Game');
        $this->setHelp('
A program, which, given a valid sequence of rolls for one line of American 
Ten-Pin Bowling, produces the total score for the game.');
        $this->addOption('score', null, InputOption::VALUE_REQUIRED, 'Score of the Game', 1);
        $this->addOption('style', null, InputOption::VALUE_OPTIONAL, 'Type of Output', 1);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $scoreLine = $input->getOption('score');
        $this->frames = $this->getFrames($scoreLine);


        for ($i = 0; $i < count($this->frames); $i++) {
            $this->getRolls($this->frames[$i], $i);
        }
        $this->calculatePoints();
        $output->write(end($this->points).PHP_EOL);
        return Command::SUCCESS;
    }

    protected function getFrames(String $score) {
        return explode(' ', $score);
    }


    protected function getRolls($frame, $throw) {
        $turn = str_split($frame, 1);
        if ($throw < 9) {
            if ($turn[0] == 'X' && count($turn) == 1) {
                array_push($this->rolls, 10, 0);
            } else if ($turn[1] == '/' && count($turn) == 2) {
                array_push($this->rolls, intval($turn[0]), 10 - intval($turn[0]));
            } else if ($turn[1] == '-' && count($turn) == 2) {
                array_push($this->rolls, intval($turn[0]), 0);
            } else {
                array_push($this->rolls, intval($turn[0]), intval($turn[1]));
            }
        } else {
            foreach ($turn as $shot) {
                if ($shot == 'X') {
                    array_push($this->rolls, 10);
                } else if ($shot == '/') {
                    array_push($this->rolls, 10 - intval(end($this->rolls)));
                } else {
                    array_push($this->rolls, intval($shot));
                }
            }

        }
    }

    protected function calculatePoints() {
        $loc = 0;
        for ($i = 0; $i < count($this->rolls) - 1; $i += 2) {
            if ($this->rolls[$i] == 10 && $this->rolls[$i + 1] == 0) { //Strike
                //Need to detect two strikes in a row
                if ($this->rolls[$i + 2] == 10 && $this->rolls[$i + 3] == 0) {
                    $value = $this->rolls[$i + 2] + $this->rolls[$i + 4];
                } else {
                    $value = $this->rolls[$i + 2] + $this->rolls[$i + 3];
                }
                $this->points[] = end($this->points) + 10 + $value;
            } else if (($this->rolls[$i] + $this->rolls[$i + 1]) == 10 && $this->rolls[$i + 1] != 0) { //Spare
                $this->points[] = end($this->points) + 10 + $this->rolls[$i + 2];
            } else { // Open Frame
                $this->points[] = end($this->points) + $this->rolls[$i] + $this->rolls[$i + 1];
            }
        }
        array_shift($this->points);

        $last = 0;
        for ($i = 18; $i < count($this->rolls); $i++) {
            $last += $this->rolls[$i];
        }

        $this->points[9] = $this->points[8] + $last;
    }
}
