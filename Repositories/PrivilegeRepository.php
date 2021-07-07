<?php


namespace App\Repositories;


use App\Privilege;

class PrivilegeRepository
{
    /**
     * @var Privilege $privilege
     */
    protected $privilege;

    /**
     * PrivilegeRepository constructor.
     * @param Privilege $privilege
     */
    public function __construct(Privilege $privilege)
    {
        $this->privilege = $privilege;
    }

    public function create($path, $type, $other)
    {
        return $this->privilege->create([
            'path' => $path,
            'typeOfPrivilege_id' => $type,
            'otherPrivilege' => $other,
        ])->id;
    }


}
