<?php
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

    public function logOut(){
        echo "Logged out successfully\n";
        $this->status = "LoggedOut";

        handleLogin();
    }
}