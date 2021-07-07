<?php


namespace App\Repositories;


use App\PassportPhoto;

class PassportPhotoRepository
{
    /**
     * @var PassportPhoto $passportPhoto
     */
    protected $passportPhoto;

    /**
     * PassportPhotoRepository constructor.
     * @param PassportPhoto $passportPhoto
     */
    public function __construct(PassportPhoto $passportPhoto)
    {
        $this->passportPhoto = $passportPhoto;
    }

    public function create($path, $passportId)
    {
        $this->passportPhoto->create([
            'path' => $path,
            'passport_id' => $passportId,
        ]);
    }
}
