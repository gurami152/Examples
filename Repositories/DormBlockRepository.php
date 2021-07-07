<?php


namespace App\Repositories;


use App\DormBlock;
use Illuminate\Database\Eloquent\Builder;

class DormBlockRepository
{
    /**
     * @var DormBlock $dormBlock
     */
    protected $dormBlock;

    /**
     * @return Builder
     */
    protected function getQueryBuilder(): Builder
    {
        return $this->dormBlock->query();
    }

    /**
     * DormBlockRepository constructor.
     * @param DormBlock $dormBlock
     */
    public function __construct(DormBlock $dormBlock)
    {
        $this->dormBlock = $dormBlock;
    }

    public function all()
    {
        return $this->dormBlock->all();
    }

    public function paginated($size)
    {
        return $this->dormBlock->paginate($size);
    }

    public function selectBy(array $criteria){
        $query = $this->getQueryBuilder()
            ->whereRowValues(array_keys($criteria), '=', array_values($criteria));
        return $query->get();
    }

    public function create($name,$countOfRooms,$dorm_id,$fuck_id)
    {
        $this->dormBlock->create([
            'name' => $name,
            'countOfRooms' => $countOfRooms,
            'dormitory_id' => $dorm_id,
            'faculty_id' => $fuck_id
        ]);
    }

    public function edit($id, $name,$countOfRooms,$dormitory_id,$faculty_id)
    {
        $dormBlock = $this->dormBlock->findOrFail($id);
        $dormBlock->name = $name;
        $dormBlock->countOfRooms = $countOfRooms;
        $dormBlock->dormitory_id = $dormitory_id;
        $dormBlock->faculty_id = $faculty_id;
        $dormBlock->save();
    }

    public function delete($id)
    {
        $this->dormBlock->where('id', $id)->delete();
    }
}
