<?php


namespace App\Repositories;


use App\EducationalInstitution;

class EducationalInstitutionRepository
{
    /**
     * @var EducationalInstitution
     */
    protected $educationalInstitution;

    /**
     * EducationalInstitutionRepository constructor.
     * @param EducationalInstitution $educationalInstitution
     */
    public function __construct(EducationalInstitution $educationalInstitution)
    {
        $this->educationalInstitution = $educationalInstitution;
    }


    public function all()
    {
        return $this->educationalInstitution->all();
    }

    public function paginated($size)
    {
        return $this->educationalInstitution->paginate($size);
    }

    public function delete($id)
    {
        $this->educationalInstitution->findOrFail($id)->delete();
    }
}
