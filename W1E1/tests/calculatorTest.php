<?php declare(strict_types = 1);
use PHPUnit\Framework\TestCase;

final class CalculatorTest extends TestCase
{
    private string $pathToCalculator = "/Users/angel.angelov/Desktop/Internship/Homework/internship-homework/W1E1/calculator.php";

    public function testAddingTwoNumbersMatchesExpected(): void
    {
        $output = shell_exec("php $this->pathToCalculator --type=arithmetic --operator=plus --param1=20, --param2=25");
        $this->assertStringContainsString('45', $output);
    }

    public function testAddingTwoNumbersDoesNotMatchExpected() : void
    {
        $output = shell_exec("php $this->pathToCalculator --type=arithmetic --operator=plus --param1=20, --param2=25");
        $this->assertStringNotContainsString('55', $output);
    }

    public function testSubtractingTwoNumbersMatchesExpected(): void
    {
        $output = shell_exec("php $this->pathToCalculator --type=arithmetic --operator=minus --param1=20, --param2=25");
        $this->assertStringContainsString('-5', $output);
    }

    public function testSubtractingTwoNumbersDoesNotMatchExpected() : void
    {
        $output = shell_exec("php $this->pathToCalculator --type=arithmetic --operator=minus --param1=20, --param2=25");
        $this->assertStringNotContainsString('55', $output);
    }

    public function testMultiplyingTwoNumbersMatchesExpected(): void
    {
        $output = shell_exec("php $this->pathToCalculator --type=arithmetic --operator=multiply --param1=20, --param2=5");
        $this->assertStringContainsString('100', $output);
    }

    public function testMultiplyingTwoNumbersDoesNotMatchExpected() : void
    {
        $output = shell_exec("php $this->pathToCalculator --type=arithmetic --operator=multiply --param1=20, --param2=10");
        $this->assertStringNotContainsString('150', $output);
    }

    public function testDividingTwoNumbersMatchesExpected(): void
    {
        $output = shell_exec("php $this->pathToCalculator --type=arithmetic --operator=divide --param1=20, --param2=5");
        $this->assertStringContainsString('4', $output);
    }

    public function testDividingTwoNumbersDoesNotMatchExpected() : void
    {
        $output = shell_exec("php $this->pathToCalculator --type=arithmetic --operator=divide --param1=20, --param2=5");
        $this->assertStringNotContainsString('10', $output);
    }

    public function testModularDividingTwoNumbersMatchesExpected(): void
    {
        $output = shell_exec("php $this->pathToCalculator --type=arithmetic --operator=modular_division --param1=20, --param2=6");
        $this->assertStringContainsString('4', $output);
    }

    public function testModularDividingTwoNumbersDoesNotMatchExpected() : void
    {
        $output = shell_exec("php $this->pathToCalculator --type=arithmetic --operator=modular_division --param1=20, --param2=6");
        $this->assertStringNotContainsString('10', $output);
    }

    public function testSquareRootOfTwoNumbersMatchesExpected(): void
    {
        $output = shell_exec("php $this->pathToCalculator --type=arithmetic --operator=square_root --param1=9, --param2=4");
        $expected = "3\n2";
        $this->assertStringContainsString($expected, $output);
    }

    public function testSquareRootOfTwoNumbersDoesNotMatchExpected() : void
    {
        $output = shell_exec("php $this->pathToCalculator --type=arithmetic --operator=square_root --param1=20, --param2=6");
        $this->assertStringNotContainsString('10', $output);
    }

    public function testDividingANumberByZeroThrowsAnException() : void
    {
        $output = shell_exec("php $this->pathToCalculator --type=arithmetic --operator=divide --param1=20, --param2=0");
        $this->assertStringContainsString("You cant divide by zero", $output);
    }

    public function testModularDividingANumberByZeroThrowsAnException() : void
    {
        $output = shell_exec("php $this->pathToCalculator --type=arithmetic --operator=modular_division --param1=20, --param2=0");
        $this->assertStringContainsString("You cant divide by zero", $output);
    }
}