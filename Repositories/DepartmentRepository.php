<?php


namespace App\Repositories;


use App\Department;

class DepartmentRepository
{
    /**
     * @var Department $department
     */

    protected $department;

    /**
     * departmentRepository constructor.
     * @param Department $department
     */
    public function __construct(Department $department)
    {
        $this->department = $department;
    }

    public function all()
    {
        return $this->department->all();
    }

    /**
     * @param $size
     * @return mixed
     */
    public function paginated($size)
    {
        return $this->department->paginate($size);
    }

    public function create($name)
    {
        $this->department->create([
            'name' => $name
        ]);
    }

    public function edit($id, $name)
    {

        $department = $this->department->findOrFail($id);
        $department->name = $name;
        $department->save();
    }

    public function delete($id)
    {
        $this->department->where('id', $id)->delete();
    }

}
