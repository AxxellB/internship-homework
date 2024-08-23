<?php

include'./src/Student.php';
include './src/Teacher.php';
include './src/Admin.php';

$subjectsAndGrades = [
    "maths" => [5, 4, 6],
    "history" => [3, 5, 2],
];

$subjects = [
    "maths", "history"
];


$s = new Student(1,"Test", "test1", "Angel", "Angelov", $subjectsAndGrades);
$t = new Teacher(2,"Test", "test2", "Ivan", "Ivanov", $subjects);
$a = new Admin(3,"Test", "test3", "Georgi", "Georgiev");
$users = [$s, $t, $a];

function login($username, $password, $user){
    if($username == $user->username && $password == $user->password){
        return true;
    }
    return false;
}

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
            $login = login($input_username, $input_password, $user);
            if ($login) {
                $user->status = "LoggedIn";
                echo "Logged in successfully!\n";
                return $user;
            }
        }
        echo "Wrong username or password!\n";
        $login_attempts--;
    }
}

$loggedUser = handleLogin();

if($loggedUser){
    if($loggedUser->role == "admin"){
        $loggedUser->run($subjects, $users);
    }
    else if($loggedUser->role == "teacher"){
        $loggedUser->run($subjects, $users);
    }

}
