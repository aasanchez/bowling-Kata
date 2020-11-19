<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class BowlingCommand extends Command
{

    protected static $defaultName = 'bowling:get-score';

    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Start a new Game');
        $this->setHelp('
A program, which, given a valid sequence of rolls for one line of American 
Ten-Pin Bowling, produces the total score for the game.');
        $this->addOption('score',null,InputOption::VALUE_REQUIRED,'Score of the Game',1);
    }

    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $score = $input->getOption('score');
        $frames = $this->split($score);
        $score = 0;

        foreach($frames as &$frame){
            if($frame = 'X'){
                $score += 10;
            }
            
        }
        $output->writeln($score);
        return Command::SUCCESS;
    }

    protected function split(String $score){
        return explode(' ', $score);
    }

    protected function getValue(String $var = null)
    {
        # code...
    }
}
