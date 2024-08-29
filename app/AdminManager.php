<?php
namespace App;
use App\Helpers\Sanitize;
use App\Storage\StorageFactory;

class AdminManager
{
    private Sanitize $sanitize;
    private  $validation;
    private $storage;
    public function __construct() {

        $config = require './config/config.php';
        $this->storage = StorageFactory::getStorage($config);
  
        $this->sanitize = new Sanitize;
        $this->validation = new Validation;
        
    }
    public function  registerAdmin()  {
        $name = trim(readline("Enter Your Name: "));
        while (empty($name)||(is_numeric($name))) {
            echo "You must give a valid name:\n";
            $name =  trim(readline("Enter Your Name: "));
        }
        $email = trim(readline("Enter Your Email: "));
        while (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "You must give a valid email:\n";
            $email = trim(readline("Enter a valid email: "));
        }

        if ($this->storage::class === 'App\Storage\FileStorage') {
            $admins = $this->storage->loadData("admins.json");
        }else{
            $admins = $this->storage->loadData("users");
        }
       
        $adminEmailFound = false;
        foreach ($admins as $admin) {
            if ($admin['email'] == $email) {
                $adminEmailFound = true;
                break; 
            }
        }

        while ($adminEmailFound) {
            echo "This email already exists! Please enter a different email:\n";
            $email = trim(readline("Enter a valid email: "));
            while (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "You must give a valid email:\n";
                $email = trim(readline("Enter a valid email: "));
            }
            
            // Check again if the new email already exists
            $adminEmailFound = false;
            foreach ($admins as $admin) {
                if ($admin['email'] == $email) {
                    $adminEmailFound = true;
                    break;
                }
            }
        }

        $password = trim(readline("Enter Your password: "));
        while (empty($password)||(strlen($password) < 4)) {
            echo "Please provide a password longer than 4 characters!:\n";
            $password =  trim(readline("Enter a valid password: "));
        }


        if ($this->storage::class === 'App\Storage\FileStorage') {
            $userData = array(
                "name"=> $name,
                "email"=> $email,
                "password"=> password_hash($password,PASSWORD_BCRYPT),
                "role"=> 'admin'
            );
            $this->storage->saveData($userData, "admins.json");
            echo "registration is successful";
            exit;
        }else{
            $userData = [
                "name" => $name,
                'email' => $email,
                "password" => password_hash($password, PASSWORD_BCRYPT),
                'account_no' => uniqid('bbank', rand(1000, 9999)),
                'role' => 'admin',
            ];
            $this->storage->saveData( $userData);
            echo "registration is successful";
            exit;
        }
        
    }

    public function loginAdmin($email, $password) 
    {
        $admins = $this->storage->loadData("admins.json");
        foreach ($admins as $admin) {
            if ($admin['email'] == $email && password_verify($password, $admin['password'])) {
                return true;
            }
        }
        return  $this->validation->addError('auth_error',"Email or Password is not valid");
    }
}


        