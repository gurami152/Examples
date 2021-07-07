<?php

namespace App\Http\Controllers;

use App\Services\CinemaTheaterService;
use Illuminate\Http\Request;

class CinemaTheaterController extends Controller
{
    /**
     * @var CinemaTheaterService $cinemaTheaterService
     */
    protected $cinemaTheaterService;

    /**
     * CinemaTheaterController constructor.
     * @param CinemaTheaterService $cinemaTheaterService
     */
    public function __construct(CinemaTheaterService $cinemaTheaterService)
    {
        $this->cinemaTheaterService = $cinemaTheaterService;
    }


    public function getCinemaTheater(Request $request)
    {
        return $this->cinemaTheaterService->getCinemaTheater($request);
    }
}
