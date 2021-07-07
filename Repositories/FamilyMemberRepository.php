<?php


namespace App\Repositories;


use App\FamilyMember;

class FamilyMemberRepository
{
    /**
     * @var FamilyMember $familyMember
     */
    protected $familyMember;

    /**
     * FamilyMemberRepository constructor.
     * @param FamilyMember $familyMember
     */
    public function __construct(FamilyMember $familyMember)
    {
        $this->familyMember = $familyMember;
    }

    public function all()
    {
        return $this->familyMember->all();
    }

    public function paginated($size)
    {
        return $this->familyMember->paginate($size);
    }


    public function create($fullName, $phoneNumber, $type_id, $family_id)
    {
        $this->familyMember->create([
            'fullName' => $fullName,
            'phoneNumber' => $phoneNumber,
            'typeOfFamilyMember_id' => $type_id,
            'family_id' => $family_id,
        ]);
    }

    public function edit($id, $fullName,$phoneNumber,$type_id,$family_id)
    {
        $familyMember = $this->familyMember->findOrFail($id);
        $familyMember->fullName = $fullName;
        $familyMember->phoneNumber = $phoneNumber;
        $familyMember->typeOfFamilyMember_id = $type_id;
        $familyMember->family_id = $family_id;
        $familyMember->save();
    }

    public function delete($id)
    {
        $this->familyMember->where('id', $id)->delete();
    }
}
