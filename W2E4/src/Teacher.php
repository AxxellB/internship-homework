<?php

class Teacher extends User
{
    public $subjects;

    public function __construct(string $username, string $password, string $firstName, string $lastName, string $role, array $subjects){
        parent::__construct($username, $password, $firstName, $lastName, $role);
        $this->subjects = $subjects;
    }
}