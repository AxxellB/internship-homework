<?php

include'./src/Student.php';
include './src/Teacher.php';
include './src/Admin.php';

$subjectsAndGrades = array(
    "maths" => 5,
);

$subjects = [
    "maths", "history"
];


$s = new Student("Test", "test", "Angel", "Angelov", "user", $subjectsAndGrades);
$t = new Teacher("Test", "test3", "Ivan", "Ivanov", "teacher", $subjects);
$a = new Admin("Test", "test2", "Georgi", "Georgiev", "admin");
$users = [$s, $t, $a];

function handleLogin(){
    $login_attempts = 3;
    global $users;
    while($login_attempts > 0){
        $fin = fopen("php://stdin", "r");
        echo "Enter username: ";
        $input_username = trim(fgets($fin));
        echo "Enter password: ";
        $input_password = trim(fgets($fin));

        foreach ($users as $user) {
            $login = $user->login($input_username, $input_password);
            if ($login) {
                $user->status = "LoggedIn";
                echo "Logged in successfully!";
                return true;
            }
        }
        echo "Wrong username or password!\n";
        $login_attempts--;
    }
}

handleLogin();
