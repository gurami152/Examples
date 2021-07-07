<?php


namespace App\Repositories;


use App\Course;

class CourseRepository
{
    /**
     * @var Course $cource
     */
    protected $cource;

    /**
     * CourseRepository constructor.
     * @param Course $cource
     */
    public function __construct(Course $cource)
    {
        $this->cource = $cource;
    }

    public function all()
    {
        return Course::all();
    }

    public function paginated($size)
    {
        return Course::paginate($size);
    }

    public function delete($id)
    {
        $this->cource->findOrFail($id)->delete();
    }
}
