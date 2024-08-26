<?php

use PHPUnit\Framework\TestCase;
use App\App\Teacher;
use App\App\Student;

class TeacherTest extends TestCase
{
    private $teacher;
    private $subjects;
    private $users;

    public $subjectsAndGrades = [
        "maths" => [],
        "history" => [],
    ];
    protected function setUp(): void
    {
        $this->users = [
            $s = new Student(1,"Test", "test1", "Angel", "Angelov", $this->subjectsAndGrades),
        ];

        $this->subjects = ['maths', 'history'];
        $this->teacher = new Teacher(2, 'teacher1', 'pass1', 'Mr', 'Smith', $this->subjects);
    }

    public function testTeacherCanAssignGrades(): void
    {

        $this->teacher->run($this->subjects, $this->users);

        $this->assertEquals(5, $this->users[0]->subjectsAndGrades['maths'][0]);
    }

}
