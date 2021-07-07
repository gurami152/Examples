<?php


namespace App\Repositories;


use App\InfoForStudents;

class InfoForStudentsRepository
{
    /**
     * @var InfoForStudents $infoForStudents
     */
    protected $infoForStudents;

    /**
     * InfoForStudentsRepository constructor.
     * @param InfoForStudents $infoForStudents
     */
    public function __construct(InfoForStudents $infoForStudents)
    {
        $this->infoForStudents = $infoForStudents;
    }

    /**
     * @param $size
     * @return mixed
     */
    public function paginated($size)
    {
        return $this->infoForStudents->paginate($size);
    }

    public function create($name, $path, $lang)
    {
        $this->infoForStudents->create([
            'name' => $name,
            'path' => $path,
            'language_id' => $lang
        ]);
    }

    public function edit($id, $name, $path)
    {

        $infoForStudents = $this->infoForStudents->findOrFail($id);
        $infoForStudents->name = $name;
        if($path) $infoForStudents->path = $path;
        $infoForStudents->save();
    }

    public function delete($id)
    {
        $this->infoForStudents->where('id', $id)->delete();
    }
}
