<?php


namespace App\Repositories;


use App\Student;

class StudentRepository
{
    /**
     * @var Student $student
     */
    protected $student;

    /**
     * StudentRepository constructor.
     * @param Student $student
     */
    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    public function create($financialSource, $formOfEducation, $direction, $course)
    {
        return $this->student->create([
            'financialSource_id' => $financialSource,
            'formOfEducation_id' => $formOfEducation,
            'directionOfStudy_id' => $direction,
            'course_id' => $course
        ])->id;
    }

}
