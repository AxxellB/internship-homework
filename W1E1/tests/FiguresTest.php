<?php declare(strict_types = 1);
use PHPUnit\Framework\TestCase;

final class FiguresTest extends TestCase
{
    private string $pathToFigures = "/Users/angel.angelov/Desktop/Internship/Homework/internship-homework/W1E1/figures.php";

    public function testRadiusAreaCalculationMatchesExpected(): void
    {
        $output = shell_exec("php $this->pathToFigures --type=shape --calculation=area --shape=circle --radius=10");
        echo($output);
        $this->assertStringContainsString('314.2', $output);
    }

    public function testRadiusAreaCalculationDoesNotMatchExpected() : void
    {
        $output = shell_exec("php $this->pathToFigures --type=shape --calculation=area --shape=circle --radius=10");
        $this->assertStringNotContainsString('155', $output);
    }

    public function testRadiusPerimeterCalculationMatchesExpected(): void
    {
        $output = shell_exec("php $this->pathToFigures --type=shape --calculation=perimeter --shape=circle --radius=10");
        echo($output);
        $this->assertStringContainsString('62.8', $output);
    }

    public function testRadiusPerimeterCalculationDoesNotMatchExpected() : void
    {
        $output = shell_exec("php $this->pathToFigures --type=shape --calculation=perimeter --shape=circle --radius=10");
        $this->assertStringNotContainsString('155', $output);
    }

    public function testTriangleAreaCalculationMatchesExpected(): void
    {
        $output = shell_exec("php $this->pathToFigures --type=shape --calculation=area --shape=triangle --a=10 --b=5 --c=6");
        $this->assertStringContainsString('11.4', $output);
    }

    public function testTriangleAreaCalculationDoesNotMatchExpected() : void
    {
        $output = shell_exec("php $this->pathToFigures --type=shape --calculation=area --shape=triangle --a=10 --b=5 --c=6");
        $this->assertStringNotContainsString('56', $output);
    }

    public function testTrianglePerimeterCalculationMatchesExpected(): void
    {
        $output = shell_exec("php $this->pathToFigures --type=shape --calculation=perimeter --shape=triangle --a=10 --b=5 --c=6");
        $this->assertStringContainsString('21', $output);
    }

    public function testTrianglePerimeterCalculationDoesNotMatchExpected() : void
    {
        $output = shell_exec("php $this->pathToFigures --type=shape --calculation=perimeter --shape=triangle --a=10 --b=5 --c=6");
        $this->assertStringNotContainsString('98', $output);
    }

    public function testSquareAreaCalculationMatchesExpected(): void
    {
        $output = shell_exec("php $this->pathToFigures --type=shape --calculation=area --shape=square --a=10");
        $this->assertStringContainsString('100', $output);
    }

    public function testSquareAreaCalculationDoesNotMatchExpected() : void
    {
        $output = shell_exec("php $this->pathToFigures --type=shape --calculation=area --shape=square --a=10");
        $this->assertStringNotContainsString('56', $output);
    }

    public function testSquarePerimeterCalculationMatchesExpected(): void
    {
        $output = shell_exec("php $this->pathToFigures --type=shape --calculation=perimeter --shape=square --a=10");
        $this->assertStringContainsString('40', $output);
    }

    public function testSquarePerimeterCalculationDoesNotMatchExpected() : void
    {
        $output = shell_exec("php $this->pathToFigures --type=shape --calculation=perimeter --shape=square --a=10");
        $this->assertStringNotContainsString('80', $output);
    }

    public function testRunningScriptWithoutPassingValuesNeededForCalculation() : void
    {
        $outputSquare = shell_exec("php $this->pathToFigures --type=shape --calculation=perimeter --shape=square --a=");
        $outputTriangle = shell_exec("php $this->pathToFigures --type=shape --calculation=perimeter --shape=triangle --a= --b= --c=");
        $outputCircle = shell_exec("php $this->pathToFigures --type=shape --calculation=perimeter --shape=circle");
        $this->assertStringContainsString('Please provide value for side a', $outputSquare);
        $this->assertStringContainsString('Please provide values for the 3 sides', $outputTriangle);
        $this->assertStringContainsString('Please provide a value for radius', $outputCircle);
    }

}