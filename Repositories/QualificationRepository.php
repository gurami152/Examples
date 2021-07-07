<?php


namespace App\Repositories;


use App\Qualification;

class QualificationRepository
{
    /**
     * @var Qualification $qualification
     */
    protected $qualification;

    /**
     * QualificationRepository constructor.
     * @param Qualification $qualification
     */
    public function __construct(Qualification $qualification)
    {
        $this->qualification = $qualification;
    }


    public function all()
    {
        return Qualification::all();
    }

    public function paginated($size)
    {
        return Qualification::paginate($size);
    }

    public function delete($id)
    {
        $this->qualification->findOrFail($id)->delete();
    }
}
