<?php


namespace App\Repositories;


use App\FluorographyPhoto;

class FluorographyPhotoRepository
{
    /**
     * @var FluorographyPhoto
     */
    protected $fluorographyPhoto;

    /**
     * FluorographyPhotoRepository constructor.
     * @param FluorographyPhoto $fluorographyPhoto
     */
    public function __construct(FluorographyPhoto $fluorographyPhoto)
    {
        $this->fluorographyPhoto = $fluorographyPhoto;
    }


    public function create($path, $fluorography_id)
    {
        $this->fluorographyPhoto->create([
            'path' => $path,
            'fluorography_id' => $fluorography_id,
        ]);
    }
}
