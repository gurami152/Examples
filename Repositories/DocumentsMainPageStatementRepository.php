<?php


namespace App\Repositories;


use App\DocumentsMainPageStatement;

class DocumentsMainPageStatementRepository
{
    /**
     * @var DocumentsMainPageStatement $documentsMainPageStatement
     */
    protected $documentsMainPageStatement;

    /**
     * DocumentsMainPageStatementRepository constructor.
     * @param DocumentsMainPageStatement $documentsMainPageStatement
     */
    public function __construct(DocumentsMainPageStatement $documentsMainPageStatement)
    {
        $this->documentsMainPageStatement = $documentsMainPageStatement;
    }

    public function paginated($size)
    {
        return $this->documentsMainPageStatement->paginate($size);
    }

    public function create($name, $path, $lang)
    {
        $this->documentsMainPageStatement->create([
            'name' => $name,
            'path' => $path,
            'language_id' => $lang
        ]);
    }

    public function edit($id, $name, $path)
    {

        $infoForStudents = $this->documentsMainPageStatement->findOrFail($id);
        $infoForStudents->name = $name;
        if($path) $infoForStudents->path = $path;
        $infoForStudents->save();
    }

    public function delete($id)
    {
        $this->documentsMainPageStatement->where('id', $id)->delete();
    }
}
