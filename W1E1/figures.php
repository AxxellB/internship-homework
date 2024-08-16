<?php

$longopts = array(
    "type:",
    "calculation:",
    "shape:",
    "radius::",
    "a::",
    "b::",
    "c::",
);  

$options = getopt("", $longopts);
if ($options["calculation"] == "area") {
    $shape = $options["shape"];

    switch ($shape) {
        case "circle":
            $radius = $options["radius"];
            if ($radius) {
                $area = pi() * $radius * $radius;
                $area = round($area, 1);
                echo $area;
            } else {
                echo "Please provide a value for radius";
            }
            break;
        case "triangle":
            $a = $options['a'];
            $b = $options['b'];
            $c = $options['c'];
            if ($a && $b && $c) {
                $perimeter = $a + $b + $c;
                $semiperimeter = ($a + $b + $c) / 2;
                $area = sqrt($semiperimeter * ($semiperimeter - $a) * ($semiperimeter - $b) * ($semiperimeter - $c));
                $area = round($area, 1);
                echo $area;
            } else {
                echo "Please provide values for the 3 sides";
            }
            break;
        case "square":
            $a = $options["a"];
            if ($a) {
                $area = $a * $a;
                $area = round($area, 1);
                echo $area;
            } else {
                echo "Please provide value for side a";
            }
            break;
    }
} elseif ($options["calculation"] == "perimeter") {
    $shape = $options["shape"];

    switch ($shape) {
        case "circle":
            $radius = $options["radius"];
            if ($radius) {
                $perimeter = 2 * pi() * $radius;
                $perimeter = round($perimeter, 1);
                echo $perimeter;
            } else {
                echo "Please provide a value for radius";
            }
            break;
        case "triangle":
            $a = $options['a'];
            $b = $options['b'];
            $c = $options['c'];
            if ($a && $b && $c) {
                $perimeter = $a + $b + $c;
                $perimeter = round($perimeter, 1);
                echo $perimeter;
            } else {
                echo "Please provide values for the 3 sides";
            }
            break;
        case "square":
            $a = $options["a"];
            if ($a) {
                $perimeter = 4 * $a;
                $perimeter = round($perimeter, 1);
                echo $perimeter;
            } else {
                echo "Please provide value for side a";
            }
            break;
    }
} else {
    echo "Please provide operation type!";
}