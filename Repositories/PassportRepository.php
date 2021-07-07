<?php


namespace App\Repositories;


use App\Passport;

class PassportRepository
{
    /**
     * @var Passport
     */
    protected $passport;

    /**
     * PassportRepository constructor.
     * @param Passport $passport
     */
    public function __construct(Passport $passport)
    {
        $this->passport = $passport;
    }

    public function create(
        $typeOfPassport,
        $birthPlace,
        $passportNumber,
        $unzdr,
        $passportIssuedBy,
        $passportDateIssued,
        $series,
        $validity
    )
    {
        return $this->passport->create([
            'typeOfPassport_id' => $typeOfPassport,
            'birthPlace' => $birthPlace,
            'number' => $passportNumber,
            'unzdr' => $unzdr,
            'issuedBy' => $passportIssuedBy,
            'dateIssued' => $passportDateIssued,
            'series' => $series,
            'validity' => $validity,
        ]);
    }

}
