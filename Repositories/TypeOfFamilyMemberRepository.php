<?php


namespace App\Repositories;


use App\TypeOfFamilyMember;

class TypeOfFamilyMemberRepository
{
    public function all()
    {
        return TypeOfFamilyMember::all();
    }

    public function paginated($size)
    {
        return TypeOfFamilyMember::paginate($size);
    }

    public function forWorker()
    {
        return TypeOfFamilyMember::where('forWorker', 1)->get();
    }

    public function forStudent()
    {
        return TypeOfFamilyMember::where('forStudent', 1)->get();
    }

    public function store($request)
    {
        TypeOfFamilyMember::create([
            'forWorker' => $request->forWorker,
            'forStudent' => $request->forStudent,
            'name' => $request->name,
        ]);
    }

    public function update($request, $id)
    {
        $type = TypeOfFamilyMember::findOrFail($id);
        $type->forWorker = $request->forWorker;
        $type->name = $request->name;
        $type->forStudent = $request->forStudent;
        $type->save();
    }

    public function delete($id)
    {
        TypeOfFamilyMember::where('id', $id)->delete();
    }
}
