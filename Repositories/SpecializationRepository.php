<?php


namespace App\Repositories;


use App\Specialization;

class SpecializationRepository
{
    /**
     * @var Specialization $specialization
     */
    protected $specialization;

    /**
     * SpecializationRepository constructor.
     * @param Specialization $specialization
     */
    public function __construct(Specialization $specialization)
    {
        $this->specialization = $specialization;
    }

    public function all()
    {
        return Specialization::all();
    }

    public function paginated($size)
    {
        return Specialization::paginate($size);
    }

    public function delete($id)
    {
        $this->specialization->findOrFail($id)->delete();
    }
}
