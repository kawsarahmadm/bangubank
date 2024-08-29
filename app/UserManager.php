<?php
namespace App;

use App\Helpers\Sanitize;

class UserManager
{
    private $fileHandler;
    private $validation;
    public function __construct(FileHandler $fileHandler, Validation  $validation) {
        $this->fileHandler = $fileHandler;
        $this->validation = $validation;
    }
    public function register(User $user) 
    {
        $sanitize = new Sanitize;
        $users = $this->fileHandler->loadData();
        
        foreach ($users as $existingUser) {
            if ($existingUser['email'] === $user->getEmail()) {
                $this->validation->addError('email',"this email is already exists!");
                return false;
            }
        }
        $userData = array(
            "id"=> $user->getId(),
            "name"=> $sanitize->sanitize($user->getName()),
            "email"=> $user->getEmail(),
            "password"=> password_hash($user->getPassword(),PASSWORD_BCRYPT),
        );

        if ($this->fileHandler->saveData($userData)) {
            return true;
        }else{
            $this->validation->addError('auth_error',"failed to register user! please try again!");
            return false;
        }
    }

    public function login($email, $password) 
    {
        $users = $this->fileHandler->loadData();
        
        foreach ($users as $user) {
            if ($user['email'] === $email && password_verify($password,$user['password'] ) ) {
                // echo "success login";
                return true;
            }
        }
        return  $this->validation->addError('auth_error',"Email or Password is not valid");
    }
   

}