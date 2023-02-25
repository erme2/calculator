<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Operation
{
    #[Assert\Type('numeric', message: 'First number must be a number!')]
    private $firstNumber;
    #[Assert\Choice(['+', '-', '*', '/'], message: 'Operator must be one of the following: +, -, *, /')]
    private $operator;
    #[Assert\Type('numeric', message: 'Second number must be a number!')]
    private $secondNumber;

    /**
     * @param $firstNumber
     * @param $operator
     * @param $secondNumber
     */
    public function __construct($firstNumber, $operator, $secondNumber)
    {
        $this->firstNumber = (float) $firstNumber;
        $this->operator = $operator;
        $this->secondNumber = (float) $secondNumber;
    }

    /**
     * executes the requested operation and returns the result
     *
     * @return float
     * @throws \Exception
     */
    public function calculate(): float
    {
        switch ($this->operator) {
            case '+':
                return $this->firstNumber + $this->secondNumber;
            case '-':
                return $this->firstNumber - $this->secondNumber;
            case '*':
                return $this->firstNumber * $this->secondNumber;
            case '/':
                if ($this->secondNumber === 0) {
                    throw new \Exception('Division by zero is not allowed!');
                } else {
                    return $this->firstNumber / $this->secondNumber;
                }
        }
    }
}