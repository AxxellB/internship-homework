<?php

include 'User.php';
class Student extends User
{
    public array $subjectsAndGrades;
    public string $role = "student";

    public function __construct(int $id, string $username, string $password, string $firstName, string $lastName, array $subjectsAndGrades){
        parent::__construct($id, $username, $password, $firstName, $lastName);
        $this->subjectsAndGrades = $subjectsAndGrades;
    }
}