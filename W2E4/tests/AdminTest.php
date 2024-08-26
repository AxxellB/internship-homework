<?php
use App\App\Admin;
use App\App\Teacher;
use App\App\Student;
use PHPUnit\Framework\TestCase;

class AdminTest extends TestCase
{
    private $admin;
    private $subjects;
    private $users;

    protected function setUp(): void
    {
        $this->admin = new Admin(1, 'adminUser', 'adminPass', 'Admin', 'User');

        $this->subjects = ['math', 'history'];

        $teacher = new Teacher(2, 'teacherUser', 'teacherPass', 'Teacher', 'One', ['Math']);
        $student = new Student(3, 'studentUser', 'studentPass', 'Student', 'One', [
            'math' => [5, 4, 6],
            'history' => [3, 5, 2]
        ]);
        $this->users = [$this->admin, $teacher, $student];

    }

    public function testCreateSubjectWorksProperly()
    {
        $this->admin->createSubject($this->subjects, $this->users);
        $this->assertEquals(3, count($this->subjects));
        $this->assertEquals("geography", end($this->subjects));
    }

    public function testCreateTeacherWorksProperly()
    {
        $this->admin->createTeacher($this->subjects, $this->users);

        $this->assertEquals(4, count($this->users));
        $this->assertEquals('teacher', end($this->users)->role);
    }

    public function testCreateStudentWorksProperly()
    {
        $this->admin->createStudent($this->subjects, $this->users);

        $this->assertEquals(4, count($this->users));
        $this->assertEquals('student', end($this->users)->role);
    }

    public function testRemoveSubjectWorksProperly()
    {
        $this->admin->removeSubject($this->subjects, $this->users);

        $this->assertEquals(2, count($this->subjects));
        $this->assertEquals("geography", end($this->subjects));
    }


    public function testRemoveTeacherWorksProperly(){
        $this->admin->removeTeacher($this->subjects, $this->users);

        $this->assertEquals(3, count($this->users));
    }

    public function testRemoveStudentWorksProperly(){
        $this->admin->removeTeacher($this->subjects, $this->users);

        $this->assertEquals(3, count($this->users));
    }
}
