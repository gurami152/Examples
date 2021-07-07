<?php


namespace App\Repositories;


use App\Worker;

class WorkerRepository
{
    /**
     * @var Worker $worker
     */
    protected $worker;

    /**
     * WorkerRepository constructor.
     * @param Worker $worker
     */
    public function __construct(Worker $worker)
    {
        $this->worker = $worker;
    }

    public function create($department)
    {
        return $this->worker->create([
            'department_id' => $department,
        ])->id;
    }

}
