<?php


namespace App\Repositories;


use App\Family;

class FamilyRepository
{
    /**
     * @var Family $family
     */
    protected $family;

    /**
     * FamilyRepository constructor.
     * @param Family $family
     */
    public function __construct(Family $family)
    {
        $this->family = $family;
    }

    public function create($path)
    {
        return $this->family->create([
            'familyStatementFile' => $path
        ])->id;
    }

    public function changeUserPhoto($family_id, $path)
    {
        $family = $this->family->find($family_id);
        $family->familyStatementFile = $path;
        $family->save();
    }

}
