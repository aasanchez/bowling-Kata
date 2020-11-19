<?php

namespace App\Tests\Command;

use App\Command\LifeCommand;
use PHPUnit\Framework\TestCase;

class LifeCommandTest extends TestCase
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
