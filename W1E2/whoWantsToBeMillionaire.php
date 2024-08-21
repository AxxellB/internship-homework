<?php

$game_data = [
    array(
        "question" => "What does 2+3 equal?",
        "answers" => [
            5,
            7,
            9,
            1
        ],
        "correct_answer" => 5,
    ),
    array(
        "question" => "What is the capitol of France",
        "answers" => [
            "Paris",
            "London",
            "Sofia",
            "Madrid"
        ],
        "correct_answer" => "Paris"
    ),
    array(
        "question" => "Which element has the chemical symbol 'O'?",
        "answers" => [
            "Oxygen",
            "Gold",
            "Hydrogen",
            "Carbon"
        ],
        "correct_answer" => "Oxygen"
    ),
    array(
        "question" => "Who wrote Romeo and Juliet?",
        "answers" => [
            "William Shakespeare",
            "Charles Dickens",
            "Mark Twain",
            "Jane Austin",
        ],
        "correct_answer" => "William Shakespeare"
    ),
    array(
        "question" => "What is the largest planet in our solar system?",
        "answers" => [
            "Jupiter",
            "Earth",
            "Mars",
            "Saturn",
        ],
        "correct_answer" => "Jupiter"
    ),
    array(
        "question" => "Which organ is responsible for pumping blood throughout the body?",
        "answers" => [
            "Heart",
            "Liver",
            "Lungs",
            "Kidney"
        ],
        "correct_answer" => "Heart",
    ),
    array(
        "question" => "What is the process by which plants make their food?",
        "answers" => [
            "Photosynthesis",
            "Respiration",
            "Transpiration",
            "Fermentation"
        ],
        "correct_answer" => "Photosynthesis",
    ),
    array(
        "question" => "Which planet is known as the Red Planet?",
        "answers" => [
            "Mars",
            "Venus",
            "Mercury",
            "Neptune"
        ],
        "correct_answer" => "Mars",
    ),
    array(
        "question" => "Which ocean is the largest by surface area?",
        "answers" => [
            "Pacific Ocean",
            "Atlantic Ocean",
            "Indian Ocean",
            "Arctic Ocean"
        ],
        "correct_answer" => "Pacific Ocean",
    ),
    array(
        "question" => "Who painted the Mona Lisa?",
        "answers" => [
            "Leonardo da Vinci",
            "Vincent van Gogh",
            "Pablo Picasso",
            "Claude Monet"
        ],
        "correct_answer" => "Leonardo da Vinci",
    ),
    array(
        "question" => "What is the main ingredient in traditional guacamole?",
        "answers" => [
            "Avocado",
            "Tomato",
            "Lettuce",
            "Onion"
        ],
        "correct_answer" => "Avocado",
    ),
    array(
        "question" => "In which year did the Titanic sink?",
        "answers" => [
            "1912",
            "1905",
            "1898",
            "1920"
        ],
        "correct_answer" => "1912",
    ),
    array(
        "question" => "Which country is home to the kangaroo?",
        "answers" => [
            "Australia",
            "Brazil",
            "India",
            "South Africa"
        ],
        "correct_answer" => "Australia",
    ),
    array(
        "question" => "Which language is the most spoken worldwide?",
        "answers" => [
            "Mandarin Chinese",
            "English",
            "Spanish",
            "Hindi"
        ],
        "correct_answer" => "Mandarin Chinese",
    ),
    array(
        "question" => "What is H2O more commonly known as?",
        "answers" => [
            "Water",
            "Hydrogen",
            "Oxygen",
            "Carbon Dioxide"
        ],
        "correct_answer" => "Water",
    )
];

$prizes = array(
    100,
    200,
    300,
    500,
    1000,
    2000,
    4000,
    8000,
    16000,
    32000,
    64000,
    125000,
    250000,
    500000,
    1000000
);

function main()
{
    global $game_data, $prizes;
    $fname = "scoreboard.txt";
    $scoreboard = array();
    $scoreboard = load_scoreboard($fname, $scoreboard);
    $current_prize = 0;
    $question_counter = 0;
    $current_prize_won = 0;
    shuffle($game_data);

    $fin = fopen("php://stdin", "r");
    echo "What is your name: ";
    $input_name = trim(fgets($fin));
    while ($input_name == "") {
        echo "Please enter a name: ";
        $input_name = trim(fgets($fin));
    }

    echo "Welcome to who wants to get rich : $input_name" . "\n";
    echo "Your game will now begin!" . "\n\n";

    while (True) {
        foreach ($game_data as $current_data) {
            $current_prize = $prizes[$question_counter];
            shuffle($current_data["answers"]);

            echo "Question for $current_prize: " . $current_data["question"] . "\n";
            echo "Answers:\n";

            foreach ($current_data["answers"] as $answer) {
                echo "- " . $answer . "\n";
            }
            echo "Please type your answer: " . "\n";
            $input = trim(fgets($fin));

            if ($input == $current_data["correct_answer"] || $input == "a") {
                $current_prize_won = $prizes[$question_counter];
                echo "Correct!" . "\n\n";
                if ($question_counter == 14) {
                    echo "Congratulations $input_name! You just won $1 000 000! Your score is $current_prize \n";
                    $scoreboard["$input_name"] = $current_prize;
                    finish_game($fname, $scoreboard);
                    return;
                }
            } else {
                echo "Sorry, this was a wrong answer! Game over!" . "\n" . "Your prize is $$current_prize_won" . "\n\n";
                if (!array_key_exists($input_name, $scoreboard)) {
                    $scoreboard["$input_name"] = $current_prize_won;
                } else if ($scoreboard["$input_name"] < $current_prize_won) {
                    $scoreboard["$input_name"] = $current_prize_won;
                }
                finish_game($fname, $scoreboard);
                return;
            }
            $question_counter++;
        }
    }
}

function finish_game($fname, $scoreboard)
{
    arsort($scoreboard);
    write_to_game_file($fname, $scoreboard);
    print_scoreboard($scoreboard);
}
function print_scoreboard($scoreboard)
{
    echo "Scoreboard:\n";
    foreach ($scoreboard as $user => $score) {
        echo "User: $user - Score: $score \n";
    }
}

function write_to_game_file($fname, $array)
{
    $handle = fopen("$fname", "w");
    foreach ($array as $key => $value) {
        fwrite($handle, $key . "=");
        fwrite($handle, $value . " ");
    }
    fclose($handle);
}
function load_scoreboard($fname, $array)
{
    $handle = fopen("$fname", "r");
    while (!feof($handle)) {
        $line = trim(fgets($handle));
        $pieces = explode(" ", $line);
        foreach ($pieces as $piece) {
            $scoreboard_entry = explode("=", $piece);
            if ($scoreboard_entry[0] && $scoreboard_entry[1]) {
                $array[$scoreboard_entry[0]] = $scoreboard_entry[1];
            }
        }
    }
    fclose($handle);
    return $array;
}

if (php_sapi_name() === 'cli' && basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) {
    main();
}