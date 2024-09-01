<?php
namespace App\App;

class User
{
    public int $id;
    public string $username;
    public string $password;
    public string $firstName;
    public string $lastName;
    public string $status = "loggedOut";

    public function __construct(int $id, string $username, string $password, string $firstName, string $lastName){
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function printUsersByRole($users, $role){
        foreach ($users as $user){
            if($user->role == $role){
                echo "$user->id." . " " . $user->firstName . " " . $user->lastName . "\n";
            }
        }
    }

    public function handleStringInput(string $prompt){
        $fin = fopen("php://stdin", "r");
        echo $prompt;
        $input = trim(fgets($fin));
        while(!$input || strlen($input) < 2){
            echo "Incorrent!\n";
            echo $prompt;
            $input = trim(fgets($fin));
        }
        return $input;
    }

    public function handlePasswordInput(string $prompt){
        $fin = fopen("php://stdin", "r");
        echo $prompt;
        $input = trim(fgets($fin));
        $pattern = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/";

        while(!$input || !preg_match($pattern, $input)){
            echo "Incorrent!\n";
            echo $prompt;
            $input = trim(fgets($fin));
        }
        return $input;
    }

    public function handleSubjectsInput(string $prompt, array $subjects){
        echo $prompt;
        foreach($subjects as $subject){
            echo "$subject\n";
        }
        $fin = fopen("php://stdin", "r");
        $input = trim(fgets($fin));
        while(empty($input) || count(explode(", ", $input)) < 1){
            echo $prompt;
            foreach($subjects as $subject){
                echo "$subject\n";
            }
            $input = trim(fgets($fin));
        }
        echo $input;
        $selectedSubjects = explode(", ", $input);
        return $selectedSubjects;
    }

    public function logOut(){
        echo "Logged out successfully\n";
        $this->status = "LoggedOut";

        handleLogin();
    }
}