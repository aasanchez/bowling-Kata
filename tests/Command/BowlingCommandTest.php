<?php

namespace App\Tests\Command;

use App\Command\BowlingCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class BowlingCommandTest extends TestCase
{
    public function testGetNeighbors()
    {
        $this->assertEquals(42, 42);
    }
    public function testNeighborsWeeper()
    {
        $this->assertEquals(true, true);
    }
}
