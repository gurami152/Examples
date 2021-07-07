<?php


namespace App\Repositories;


use App\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    /**
     * @var User $user
     */
    protected $user;

    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function create($userFirstName, $userSecondName, $userLastName, $userEmail, $userPassword, $userPhone,
                           $birthDate, $gender, $passport, $address, $privilege, $student, $worker, $family,
                           $path, $pathStatement, $appealToAdministration)
    {
        return $this->user->create([
            'firstName' => $userFirstName,
            'secondName' => $userSecondName,
            'lastName' => $userLastName,
            'email' => $userEmail,
            'password' => Hash::make($userPassword),
            'phoneNumber' => $userPhone,
            'dateBirth' => $birthDate,
            'typeOfGenderOfPerson_id' => $gender,
            'passport_id' => $passport,
            'address_id' => $address,
            'isSettle' => true,
            'privilege_id' => $privilege,
            'student_id' => $student,
            'worker_id' => $worker,
            'family_id' => $family,
            'userPhoto' => $path,
            'statementFilePath' => $pathStatement,
            'appealToTheAdministration' => $appealToAdministration,
        ]);
    }

    public function checkEmail($email)
    {
        $user = $this->user->where('email', $email)->first();
        if($user){
            return false;
        }
        return true;
    }

    public function changeUserPhoto($user, $path)
    {
        $user = $this->user->find($user);
        $user->userPhoto = $path;
        $user->save();
    }

}
