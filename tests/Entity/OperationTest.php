<?php

namespace App\Tests\Entity;

use App\Entity\Operation;
use PHPUnit\Framework\TestCase;

class OperationTest extends TestCase
{

    public function testCalculatePlus()
    {
        $operation = new Operation(1, '+', 2);
        $this->assertEquals(3, $operation->calculate());
    }

    public function testCalculateMinus()
    {
        $operation = new Operation(1, '-', 2);
        $this->assertEquals(-1, $operation->calculate());
    }

    public function testCalculateMultiply()
    {
        $operation = new Operation(2, '*', 2);
        $this->assertEquals(4, $operation->calculate());
    }

    public function testCalculateDivide()
    {
        $operation = new Operation(5, '/', 2);
        $this->assertEquals(2.5, $operation->calculate());
    }

    public function testCalculateDivideByZero()
    {
        $this->expectException(\DivisionByZeroError::class);
        $this->expectExceptionMessage('Division by zero');
        $operation = new Operation(5, '/', 0);
        $operation->calculate();
    }

    public function testCalculateInvalidOperator()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid operator');
        $operation = new Operation(5, 'a', 0);
        $operation->calculate();
    }
}
