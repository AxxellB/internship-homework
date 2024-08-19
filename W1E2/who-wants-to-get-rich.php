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

function main()
{
    global $game_data;
    $fname = "scoreboard.txt";
    $scoreboard = array();
    $scoreboard = load_scoreboard($fname, $scoreboard);
    $current_score = 0;

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
            echo "Question: " . $current_data["question"] . "\n";
            echo "Answers:\n";

            foreach ($current_data["answers"] as $answer) {
                echo "- " . $answer . "\n";
            }

            echo "Please type your answer: " . "\n";
            $input = trim(fgets($fin));

            if ($input == $current_data["correct_answer"]) {
                echo "Correct!" . "\n\n";
                $current_score += 100;
            } else {
                echo "Sorry, this was a wrong answer! Game over!" . "\n" . "Your score is $current_score" . "\n\n";
                if (!array_key_exists($input_name, $scoreboard)) {
                    $scoreboard["$input_name"] = $current_score;
                } else if ($scoreboard["$input_name"] < $current_score) {
                    $scoreboard["$input_name"] = $current_score;
                }
                write_to_game_file("$fname", $scoreboard);
                return;
            }
        }
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
            $array[$scoreboard_entry[0]] = $scoreboard_entry[1];
        }
    }
    fclose($handle);
    return $array;
}

main();
