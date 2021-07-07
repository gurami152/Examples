<?php


namespace App\Services;


use App\Repositories\AddressRepository;
use App\Repositories\DirectionOfStudyRepository;
use App\Repositories\FamilyMemberRepository;
use App\Repositories\FamilyRepository;
use App\Repositories\FileRepository;
use App\Repositories\FluorographyPhotoRepository;
use App\Repositories\FluorographyRepository;
use App\Repositories\MedicalVaccineRepository;
use App\Repositories\PassportPhotoRepository;
use App\Repositories\PassportRepository;
use App\Repositories\PrivilegeRepository;
use App\Repositories\StudentRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserRoomSelectionRepository;
use App\Repositories\WorkerRepository;
use Illuminate\Http\JsonResponse;

class RegisterService
{

    protected $userRepository;
    protected $studentRepository;
    protected $directionOfStudyRepository;
    protected $workerRepository;
    protected $passportRepository;
    protected $passportPhotoRepository;
    protected $familyRepository;
    protected $familyMemberRepository;
    protected $addressRepository;
    protected $privilegeRepository;
    protected $fluorographyRepository;
    protected $fluorographyPhotoRepository;
    protected $medicalVaccineRepository;
    protected $userRoomSelectionRepository;
    protected $fileRepository;

    /**
     * RegisterService constructor.
     * @param UserRepository $userRepository
     * @param StudentRepository $studentRepository
     * @param DirectionOfStudyRepository $directionOfStudyRepository
     * @param WorkerRepository $workerRepository
     * @param PassportRepository $passportRepository
     * @param PassportPhotoRepository $passportPhotoRepository
     * @param FamilyRepository $familyRepository
     * @param FamilyMemberRepository $familyMemberRepository
     * @param AddressRepository $addressRepository
     * @param PrivilegeRepository $privilegeRepository
     * @param FluorographyRepository $fluorographyRepository
     * @param FluorographyPhotoRepository $fluorographyPhotoRepository
     * @param MedicalVaccineRepository $medicalVaccineRepository
     * @param UserRoomSelectionRepository $userRoomSelectionRepository
     * @param FileRepository $fileRepository
     */
    public function __construct(
        UserRepository $userRepository,
        StudentRepository $studentRepository,
        DirectionOfStudyRepository $directionOfStudyRepository,
        WorkerRepository $workerRepository,
        PassportRepository $passportRepository,
        PassportPhotoRepository $passportPhotoRepository,
        FamilyRepository $familyRepository,
        FamilyMemberRepository $familyMemberRepository,
        AddressRepository $addressRepository,
        PrivilegeRepository $privilegeRepository,
        FluorographyRepository $fluorographyRepository,
        FluorographyPhotoRepository $fluorographyPhotoRepository,
        MedicalVaccineRepository $medicalVaccineRepository,
        UserRoomSelectionRepository $userRoomSelectionRepository,
        FileRepository $fileRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->studentRepository = $studentRepository;
        $this->directionOfStudyRepository = $directionOfStudyRepository;
        $this->workerRepository = $workerRepository;
        $this->passportRepository = $passportRepository;
        $this->passportPhotoRepository = $passportPhotoRepository;
        $this->familyRepository = $familyRepository;
        $this->familyMemberRepository = $familyMemberRepository;
        $this->addressRepository = $addressRepository;
        $this->privilegeRepository = $privilegeRepository;
        $this->fluorographyRepository = $fluorographyRepository;
        $this->fluorographyPhotoRepository = $fluorographyPhotoRepository;
        $this->medicalVaccineRepository = $medicalVaccineRepository;
        $this->userRoomSelectionRepository = $userRoomSelectionRepository;
        $this->fileRepository = $fileRepository;
    }


    public function register($data)
    {
        $student = null;
        $worker = null;
        if($data['specialization'] == 'undefined'){
            $data['specialization'] = null;
        }
        if ($data->has('course')) {
            $direction = $this->directionOfStudyRepository->create($data['faculty'], $data['specialization']);
            $student = $this->studentRepository->create($data['financialSource'], $data['formOfEducation'], $direction,
                $data['course']);
        }
        if ($data->has('department')) {
            $worker = $this->workerRepository->create($data['department']);
        }

        $passportId = $this->passportRepository->create($data['typeOfPassport'], $data['birthPlace'],
            $data['passportNumber'], $data['passportUnzdr'], $data['passportIssuedBy'], $data['passportDateIssued'], $data['passportSeries'],
            $data['passportDatePeriod'])->id;

        // фото нового паспорта
        if ($data->hasFile('newPassportPhoto1')) {
            $path = $this->fileRepository->imageSave($data->file('newPassportPhoto1'), 'images/passportPhoto');
            $this->passportPhotoRepository->create($path, $passportId);
        }
        if ($data->hasFile('newPassportPhoto2')) {
            $path = $this->fileRepository->imageSave($data->file('newPassportPhoto2'), 'images/passportPhoto');
            $this->passportPhotoRepository->create($path, $passportId);
        }
        if ($data->hasFile('newPassportPhoto3')) {
            $path = $this->fileRepository->imageSave($data->file('newPassportPhoto3'), 'images/passportPhoto');
            $this->passportPhotoRepository->create($path, $passportId);
        }
        // фото старого пасспорта
        if ($data->hasFile('oldPassportPhoto1')) {
            $path = $this->fileRepository->imageSave($data->file('oldPassportPhoto1'), 'images/passportPhoto');
            $this->passportPhotoRepository->create($path, $passportId);
        }
        if ($data->hasFile('oldPassportPhoto2')) {
            $path = $this->fileRepository->imageSave($data->file('oldPassportPhoto2'), 'images/passportPhoto');
            $this->passportPhotoRepository->create($path, $passportId);
        }
        if ($data->hasFile('oldPassportPhoto3')) {
            $path = $this->fileRepository->imageSave($data->file('oldPassportPhoto3'), 'images/passportPhoto');
            $this->passportPhotoRepository->create($path, $passportId);
        }
        // фото семьи и сама семья
        if ($data->hasFile('familyPhotoAjax')) {
            $path = $this->fileRepository->imageSave($data->file('familyPhotoAjax'), 'images/familyPhoto');
        } else {
            $path = "";
        }
        $family = $this->familyRepository->create($path);
        //члены семьи
        if ($data->has('members')) {
            $arr = json_decode($data->members, true);
            for ($i = 0; $i < count($arr); $i++) {
                if ($arr[$i] != null) {
                    $this->familyMemberRepository->create($arr[$i][0], $arr[$i][1], $i, $family);
                }
            }
        }
        $address = $this->addressRepository->create($data['regionAjax'], $data['districtAjax'], $data['typeOfCityAjax'], $data['cityAjax'], $data['typeOfStreetAjax'], $data['streetAjax'], $data['houseAjax'], $data['apartmentAjax']);
        $privilege = null;
        if (($data->has('typeOfPrivilege')) || ($data->has('otherPrivilege'))) {
            if ($data->hasFile('privilegePhotoAjax')) {
                $path = $this->fileRepository->imageSave($data->file('privilegePhotoAjax'), 'images/privilegePhoto');
            }
            $privilege = $this->privilegeRepository->create($path, $data['typeOfPrivilege'], $data['otherPrivilege']);
        }

        $pathStatement = null;
        if ($data->hasFile('statementPhoto')) {
            $pathStatement = $this->fileRepository->imageSave($data->file('statementPhoto'), 'images/statementPhoto');
        }
        if ($data->hasFile('file')) {
            $path = $this->fileRepository->imageSave($data->file('file'), 'images/userPhoto');
        }
        $user = $this->userRepository->create($data['userFirstName'], $data['userSecondName'], $data['userLastName'],
            $data['userEmail'], $data['userPassword'], $data['userPhone'], $data['birthDate'], $data['genderAjax'],
            $passportId, $address, $privilege, $student, $worker, $family, $path, $pathStatement, $data['appealToTheAdministration']);
        $userId = $user->id;

        $fluorography = $this->fluorographyRepository->create($data['lastFluorography'], $userId);
        if ($data->hasFile('photoFluorografyAjax')) {
            $path = $this->fileRepository->imageSave($data->file('photoFluorografyAjax'), 'images/medicalPhoto');
            $this->fluorographyPhotoRepository->create($path, $fluorography->id);
        }
        if ($data->hasFile('photoFluorografy2Ajax')) {
            $path = $this->fileRepository->imageSave($data->file('photoFluorografy2Ajax'), 'images/medicalPhoto');
            $this->fluorographyPhotoRepository->create($path, $fluorography->id);
        }

        if ($data->hasFile('photoVaccineAjax')) {
            $path = $this->fileRepository->imageSave($data->file('photoVaccineAjax'), 'images/medicalPhoto');
            $this->medicalVaccineRepository->create($path, $userId);
        }
//          комнаты которые выбрал пользователь
        if ($data->has('rooms')) {
            $arr = json_decode($data->rooms);
            for ($i = 0; $i < count($arr); $i++) {
                if ($arr[$i] != null) {
                    $this->userRoomSelectionRepository->create($userId, $arr[$i], $i);
                }
            }
        }
        return $user;
    }

    public function emailCheck($request): JsonResponse
    {
        return response()->json($this->userRepository->checkEmail($request->email));
    }
}
