<?php


namespace App\Repositories;


use App\DocumentsMainPage;

class DocumentsMainPageRepository
{
    /**
     * @var DocumentsMainPage $documentsMainPage
     */
    protected $documentsMainPage;

    /**
     * DocumentsMainPageRepository constructor.
     * @param DocumentsMainPage $documentsMainPage
     */
    public function __construct(DocumentsMainPage $documentsMainPage)
    {
        $this->documentsMainPage = $documentsMainPage;
    }

    public function paginated($size)
    {
        return $this->documentsMainPage->paginate($size);
    }

    public function create($name, $path, $lang)
    {
        $this->documentsMainPage->create([
            'name' => $name,
            'path' => $path,
            'language_id' => $lang
        ]);
    }

    public function edit($id, $name, $path)
    {

        $infoForStudents = $this->documentsMainPage->findOrFail($id);
        $infoForStudents->name = $name;
        if($path) $infoForStudents->path = $path;
        $infoForStudents->save();
    }

    public function delete($id)
    {
        $this->documentsMainPage->where('id', $id)->delete();
    }

}
