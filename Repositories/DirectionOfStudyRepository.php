<?php


namespace App\Repositories;


use App\DirectionOfStudy;

class DirectionOfStudyRepository
{
    /**
     * @var DirectionOfStudy
     */
    protected $directionOfStudy;

    /**
     * DirectionOfStudyRepository constructor.
     * @param DirectionOfStudy $directionOfStudy
     */
    public function __construct(DirectionOfStudy $directionOfStudy)
    {
        $this->directionOfStudy = $directionOfStudy;
    }

    public function create($faculty, $specialization)
    {
        return $this->directionOfStudy->create([
            'faculty_id' => $faculty,
            'specialization_id' => $specialization,
        ])->id;
    }
}
