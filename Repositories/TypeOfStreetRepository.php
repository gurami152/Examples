<?php


namespace App\Repositories;


use App\TypeOfStreet;

class TypeOfStreetRepository
{
    /**
     * @var TypeOfStreet $typeOfStreet
     */

    protected $typeOfStreet;

    /**
     * TypeOfStreetRepository constructor.
     * @param TypeOfStreet $typeOfStreet
     */
    public function __construct(TypeOfStreet $typeOfStreet)
    {
        $this->typeOfStreet = $typeOfStreet;
    }

    public function all()
    {
        return $this->typeOfStreet->all();
    }

    /**
     * @param $size
     * @return mixed
     */
    public function paginated($size)
    {
        return $this->typeOfStreet->paginate($size);
    }

    public function create($name,$lang)
    {
        $this->typeOfStreet->create([
            'name' => $name,
            'language_id' => $lang
        ]);
    }

    public function edit($id, $name)
    {

        $typeOfStreet = $this->typeOfStreet->findOrFail($id);
        $typeOfStreet->name = $name;
        $typeOfStreet->save();
    }

    public function delete($id)
    {
        $this->typeOfStreet->where('id', $id)->delete();
    }
}
