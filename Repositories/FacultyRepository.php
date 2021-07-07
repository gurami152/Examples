<?php


namespace App\Repositories;


use App\Faculty;

class FacultyRepository
{
    /**
     * @var Faculty $faculty
     */
    protected $faculty;

    /**
     * FacultyRepository constructor.
     * @param Faculty $faculty
     */
    public function __construct(Faculty $faculty)
    {
        $this->faculty = $faculty;
    }

    public function all()
    {
        return $this->faculty->all();
    }

    public function paginated($size)
    {
        return $this->faculty->paginate($size);
    }

    public function delete($id)
    {
        $this->faculty->findOrFail($id)->delete();
    }
}
