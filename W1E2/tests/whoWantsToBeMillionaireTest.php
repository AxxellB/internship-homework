<?php declare(strict_types = 1);
use PHPUnit\Framework\TestCase;
require "/Users/angel.angelov/Desktop/Internship/Homework/internship-homework/W1E2/whoWantsToBeMillionaire.php";

final class whoWantsToBeMillionaireTest extends TestCase
{

    private string $pathToGame = "/Users/angel.angelov/Desktop/Internship/Homework/internship-homework/W1E2/whoWantsToBeMillionaire.php";
    public function testWriteToGameFileWorksAccordingly(): void
    {
        $array = array();
        $array["test"] = 150;
        write_to_game_file("scoreboard.txt", $array);
        $this->assertFileExists("scoreboard.txt");
        $this->assertFileIsWritable("scoreboard.txt");
        $this->assertStringEqualsFile("scoreboard.txt", "test=150 ");
    }
    public function testLoadScoreboardWorksAccordingly(): void
    {
        $array = array();
        $array = load_scoreboard("scoreboard.txt", $array);
        $this->assertIsArray($array);
        $this->assertArrayHasKey("test", $array);
        $this->assertStringContainsString("150", $array["test"]);
    }

}