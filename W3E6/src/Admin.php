<?php
namespace App\App;

class Admin extends User
{
    public string $role = "admin";
    public function __construct(int $id, string $username, string $password, string $firstName, string $lastName){
        parent::__construct($id, $username, $password, $firstName, $lastName);
    }

    public function run($subjects, $users){
        echo "Admin menu\n";
        echo "1. Create a subject\n";
        echo "2. Create a teacher\n";
        echo "3. Create a student\n";
        echo "4. Remove a subject\n";
        echo "5. Remove a teacher\n";
        echo "6. Remove a student\n";
        echo "7. Log out\n";

        $fin = fopen("php://stdin", "r");
        echo "Enter an option from 1 to 7: ";
        $inputOption = trim(fgets($fin));
        switch ($inputOption) {
            case "1":
                $this->createSubject($subjects, $users);
                break;
            case "2":
                $this->createTeacher($subjects, $users);
                break;
            case "3":
                $this->createStudent($subjects, $users);
                break;
            case "4":
                $this->removeSubject($subjects, $users);
                break;
            case "5":
                $this->removeTeacher($subjects, $users);
                break;
            case "6":
                $this->removeStudent($subjects, $users);
                break;
            case "7":
                $this->logOut();
                break;
            default:
                echo "Invalid option! Please enter a valid option.\n";
                break;
        }

    }

    public function createSubject(array &$subjects, array $users){
        $inputSubject = $this->handleStringInput("Enter subject name: ");
        array_push($subjects, $inputSubject);
        $this->run($subjects, $users);
    }

    public function createTeacher(array $subjects, array &$users){
        $username = $this->handleStringInput("Enter username for teacher:");
        $password = $this->handlePasswordInput("Enter password for teacher which is 6 characters long and contains both letters and numbers:");
        $firstName = $this->handleStringInput("Enter first name:");
        $lastName = $this->handleStringInput("Enter last name:");
        $subjectsAssigned = $this->handleSubjectsInput("Please select subjects from the list separated by comma\n",$subjects);
        $lastUser = end($users);
        $newUserId = $lastUser->id + 1;

        $teacher = new Teacher($newUserId, $username, $password, $firstName, $lastName, $subjectsAssigned);
        array_push($users, $teacher);
        echo "Teacher created successfully\n";
        $this->run($subjects, $users);
    }

    public function createStudent(array $subjects, array &$users){
        $username = $this->handleStringInput("Enter username for student:");
        $password = $this->handlePasswordInput("Enter password for student which is 6 characters long and contains both letters and numbers:");
        $firstName = $this->handleStringInput("Enter first name:");
        $lastName = $this->handleStringInput("Enter last name:");
        $subjectsAssigned = $this->handleSubjectsInput("Please select subjects from the list separated by comma\n",$subjects);
        $lastUser = end($users);
        $newUserId = $lastUser->id + 1;
        $subjectsAndGradesArray = array();

        foreach ($subjectsAssigned as $subject){
            $subjectsAndGradesArray[$subject] = [];
        }

        $student = new Student($newUserId, $username, $password, $firstName, $lastName, $subjectsAndGradesArray);
        array_push($users, $student);
        echo "Student created successfully\n";
        $this->run($subjects, $users);
    }

    public function removeSubject($subjects, $users){
        foreach($subjects as $subject){
            echo "$subject\n";
        }
        $subjectName = $this->handleStringInput("Remove a subject from the list by typing its name: ");
        $index = array_search($subjectName, $subjects);
        if($index !== false){
            unset($subjects[$index]);
            echo "Subject removed successfully\n";
            foreach($users as $user){
                if($user->role == "teacher"){
                    $teacherSubjectsIndex = array_search($subjectName, $user->subjects);
                    if($teacherSubjectsIndex !== false){
                        unset($user->subjects[$teacherSubjectsIndex]);
                    }
                }
                else if($user->role == "student"){
                    unset($user->subjectsAndGrades[$subjectName]);
                }
            }
        }
        else{
            echo "Subject not found!\n";
            $this->removeSubject($subjects, $users);
        }
        $this->run($subjects, $users);
    }

    public function removeTeacher(array $subjects, array $users){
        echo "Teachers list:\n";
        $this->printUsersByRole($users, "teacher");

        echo "Type the id(the number before the name) to remove a teacher: ";
        $fin = fopen("php://stdin", "r");
        $teacherId = trim(fgets($fin));
        while(!$teacherId){
            echo "Pleasure type an id: ";
        }
        if($users[$teacherId - 1] && $users[$teacherId - 1]->role == "teacher"){
            unset($users[$teacherId - 1]);
            echo "Teacher remove successfully\n";
        }
        else{
            echo "Teacher not found!\n";
            $this->removeTeacher($subjects, $users);
        }
        $this->run($subjects, $users);
    }

    public function removeStudent(array $subjects, array $users){
        echo "Students list:\n";
        $this->printUsersByRole($users, "student");

        echo "Type the id(the number before the name) to remove a student: ";
        $fin = fopen("php://stdin", "r");
        $studentId = trim(fgets($fin));
        while(!$studentId){
            echo "Pleasure type an id: ";
        }

        foreach ($users as $user){
            if($user->id == $studentId && $user->role == "student"){
                unset($users[$studentId - 1]);
                echo "Student removed successfully!\n";
            }
        }
        $this->run($subjects, $users);
    }

}