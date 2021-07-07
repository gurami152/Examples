<?php


namespace App\Repositories;


use App\FormOfEducation;

class FormOfEducationRepository
{
    /**
     * @var FormOfEducation $formOfEducation
     */
    protected $formOfEducation;

    /**
     * FormOfEducationRepository constructor.
     * @param FormOfEducation $formOfEducation
     */
    public function __construct(FormOfEducation $formOfEducation)
    {
        $this->formOfEducation = $formOfEducation;
    }

    public function all()
    {
        return FormOfEducation::all();
    }

    public function paginated($size)
    {
        return FormOfEducation::paginate($size);
    }

    public function delete($id){
        $this->formOfEducation->findOrFail($id)->delete();
    }

}
