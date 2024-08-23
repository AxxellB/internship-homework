<?php

class Teacher extends User
{
    public $subjects;
    public string $role = 'teacher';

    public function __construct(int $id, string $username, string $password, string $firstName, string $lastName, array $subjects){
        parent::__construct($id, $username, $password, $firstName, $lastName);
        $this->subjects = $subjects;
    }

    public function run($subjects, $users){
        $currentTeacherSubjects = implode(", ", $this->subjects);
        echo "The subjects that you teach are: $currentTeacherSubjects\n";
        echo "Teacher menu\n";
        echo "1. Grade a student\n";
        echo "2. Log out\n";

        $fin = fopen("php://stdin", "r");
        echo "Enter an option from 1 to 7: ";
        $inputOption = trim(fgets($fin));
        if ($inputOption == "1") {
            $this->gradeStudent($subjects, $users);
        }
        else if ($inputOption == "2") {
            $this->logOut();
        }
    }

    public function gradeStudent($subjects, $users){
        echo "Choose a student from the list by typing their id:\n";
        $this->printUsersByRole($users, "student");
        $fin = fopen("php://stdin", "r");
        $studentId = trim(fgets($fin));
        while(!$studentId){
            echo "Pleasure enter an id: ";
        }
        if($users[$studentId-1]){
            $currentUser = $users[$studentId-1];
            echo "Choose a subject to grade from the list:\n";
            foreach ($currentUser->subjectsAndGrades as $subject => $grades){
                echo "$subject\n";
            }
            $fin = fopen("php://stdin", "r");
            $subjectInput = trim(fgets($fin));
            foreach ($currentUser->subjectsAndGrades as $subject => $grades){
                if($subjectInput == $subject){
                    echo "Enter a grade 2-6: ";
                    $fin = fopen("php://stdin", "r");
                    $gradeInput = trim(fgets($fin));
                    if($gradeInput >= 2 && $gradeInput <= 6){
                        array_push($grades, $gradeInput);
                        $currentUser->subjectsAndGrades[$subject] = $grades;
                    }
                    else {
                        echo "Invalid grade!";
                    }
                }
            }
            print_r($users);
        }else{
            echo "No student found with this id!";
            $this->gradeStudent($subjects, $users);
        }
    }

    public function logOut(){

    }
}