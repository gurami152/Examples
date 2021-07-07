<?php


namespace App\Repositories;


use App\Dormitory;

class DormitoryRepository
{
    /**
     * @var Dormitory $dormitory
     */
    protected $dormitory;

    /**
     * DormitoryRepository constructor.
     * @param Dormitory $dormitory
     */
    public function __construct(Dormitory $dormitory)
    {
        $this->dormitory = $dormitory;
    }

    public function all()
    {
        return $this->dormitory->all();
    }

    public function paginated($size)
    {
        return $this->dormitory->paginate($size);
    }

    public function languageSelect($lang)
    {
        return $this->dormitory->where('language_id',$lang)->get();
    }

    public function selected($id)
    {
        return $this->dormitory->where('id', $id)->first();
    }

    public function create($name,$lang,$description,$commandant,$phone,$headOfTheStudentCouncil,$addr)
    {
        $this->dormitory->create([
            'name' => $name,
            'description' => $description,
            'commandant' => $commandant,
            'phone' => $phone,
            'headOfTheStudentCouncil' => $headOfTheStudentCouncil,
            'language_id' => $lang,
            'address_id' => $addr
        ]);
    }

    public function edit($id, $name,$description,$commandant,$phone,$headOfTheStudentCouncil,$address_id)
    {
        $dormitory = $this->dormitory->findOrFail($id);
        $dormitory->name = $name;
        $dormitory->description = $description;
        $dormitory->commandant = $commandant;
        $dormitory->phone = $phone;
        $dormitory->headOfTheStudentCouncil = $headOfTheStudentCouncil;
        $dormitory->address_id = $address_id;
        $dormitory->save();
    }

    public function delete($id)
    {
        $this->dormitory->where('id', $id)->delete();
    }
}
