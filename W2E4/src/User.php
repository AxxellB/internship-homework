<?php
class User
{
    public string $username;
    public string $password;
    public string $firstName;
    public string $lastName;
    public string $role;
    public string $status = "loggedOut";

    public function __construct(string $username, string $password, string $firstName, string $lastName, string $role){
        $this->username = $username;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->role = $role;
    }

    public function login($username, $password) {
        if($username == $this->username && $password == $this->password){
            return true;
        }
        return false;
    }
}