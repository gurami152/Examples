<?php


namespace App\Repositories;


use App\Fluorography;

class FluorographyRepository
{
    /**
     * @var Fluorography $fluorography
     */
    protected $fluorography;

    /**
     * FluorographyRepository constructor.
     * @param Fluorography $fluorography
     */
    public function __construct(Fluorography $fluorography)
    {
        $this->fluorography = $fluorography;
    }


    public function create($lastDate, $user)
    {
        return $this->fluorography->create([
            'lastDate' => $lastDate,
            'users_id' => $user
        ]);
    }

    // TODO: reworked to FluorographyPhoto
    public function changeFluorographyPhoto($fluorography_id, $path)
    {
        $fluorography = $this->fluorography->find($fluorography_id);
        $fluorography->path = $path;
        $fluorography->save();
    }

    public function changeLastDate($fluorography_id, $value)
    {
        $fluorography = $this->fluorography->find($fluorography_id);
        $fluorography->lastDate = $value;
        $fluorography->save();
    }
}
