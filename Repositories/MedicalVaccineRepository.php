<?php


namespace App\Repositories;


use App\MedicalVaccine;

class MedicalVaccineRepository
{
    /**
     * @var MedicalVaccine $medicalVaccine
     */
    protected $medicalVaccine;

    /**
     * MedicalVaccineRepository constructor.
     * @param MedicalVaccine $medicalVaccine
     */
    public function __construct(MedicalVaccine $medicalVaccine)
    {
        $this->medicalVaccine = $medicalVaccine;
    }

    public function create($path, $user)
    {
        $this->medicalVaccine->create([
            'path' => $path,
            'users_id' => $user
        ]);
    }
}
