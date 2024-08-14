<?php

$longopts = array(
    "type:",
    "operator:",
    "param1:",
    "param2:",
);

$options = getopt("", $longopts);
if ($options["type"] == "arithmetic") {

    $param1 = $options["param1"];
    $param2 = $options["param2"];

    if (!$param1 || !$param2 || !$options["operator"]) {
        echo "Please provide 2 operands and an operator";
    } else {
        switch ($options["operator"]) {
            case "plus":
                echo $param1 + $param2;
                break;
            case "minus":
                echo $param1 - $param2;
                break;
            case "multiply":
                echo $param1 * $param2;
                break;
            case "divide":
                echo $param1 / $param2;
                break;
            case "modular_division":
                echo $param1 % $param2;
            case "square_root":
                echo sqrt($param1) . "\n";
                echo sqrt($param2);
        }
    }
}