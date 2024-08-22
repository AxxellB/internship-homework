<?php
class Admin extends User
{
    public function __construct(string $username, string $password, string $firstName, string $lastName, string $role){
        parent::__construct($username, $password, $firstName, $lastName, $role);
    }
}