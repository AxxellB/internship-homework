<?php

include 'User.php';
class Student extends User
{
    public array $subjectsAndGrades;

    public function __construct(string $username, string $password, string $firstName, string $lastName, string $role, array $subjectsAndGrades){
        parent::__construct($username, $password, $firstName, $lastName, $role);
        $this->subjectsAndGrades = $subjectsAndGrades;
    }
}