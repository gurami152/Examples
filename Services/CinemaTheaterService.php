<?php


namespace App\Services;


use App\Repositories\DormBlockRepository;
use App\Repositories\DormitoryRepository;
use App\Repositories\RoomRepository;
use Illuminate\Http\Request;

class CinemaTheaterService
{
    /**
     * @var DormitoryRepository $dormitoryRepository
     */
    protected $dormitoryRepository;

    /**
     * @var DormBlockRepository $dormBlockRepository
     */
    protected $dormBlockRepository;

    /**
     * @var RoomRepository $roomRepository
     */
    protected $roomRepository;

    /**
     * CinemaTheaterService constructor.
     * @param DormitoryRepository $dormitoryRepository
     * @param DormBlockRepository $dormBlockRepository
     */
    public function __construct(DormitoryRepository $dormitoryRepository, DormBlockRepository $dormBlockRepository, RoomRepository $roomRepository)
    {
        $this->dormitoryRepository = $dormitoryRepository;
        $this->dormBlockRepository = $dormBlockRepository;
        $this->roomRepository = $roomRepository;
    }


    public function getCinemaTheater(Request $request)
    {
        if ($request->has('faculty_id')) {
            $dorm = $this->dormitoryRepository->selected($request->hostel_id);
            if ($dorm->getBlocks()->exists()) {
                $blocks = $this->dormBlockRepository->selectBy(['dormitory_id' => $request->hostel_id, 'faculty_id' => $request->faculty_id]);
                foreach ($blocks as $block) {
                    if ($request->getGender) {
                        $rooms = $this->roomRepository->selectBy(['typeOfGenderOfRoom_id' => $request->gender_id, 'dormBlock_id' => $block->id]);
                        $block['blocks'] = $rooms;
                    } else {
                        $block['blocks'] = $this->roomRepository->selectBy(['dormBlock_id' => $block->id]);
                    }
                }
//                dd($blocks);
                $arc['block'] = $blocks;
            }
//              else {
//                $flours = Flour::where('dormitory_id', $request->hostel_id)->get();
//                foreach ($flours as $flour) {
//                    if ($request->getGender) {
//                        $flour['flours'] = Room::where('flour_id', $flour->id)
//                            ->where('typeOfGenderOfRoom_id', $request->gender_id)->get();
//                    } else {
//                        $flour['flours'] = Room::where('flour_id', $flour->id)->get();
//                    }
//                }
//                $arc['flour'] = $flours;
//            }
            return response()->json($arc);
        }
    }
}
