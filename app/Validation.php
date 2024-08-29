<?php
namespace App;
use App\Helpers\Sanitize;
class Validation
{
    private $errors = [];


    public function nameValidate(string $name, string $field, $msg)
    {
        if (empty($name)) {
            $this->addError($field, $msg);
            return false;
        }
        return $name;
    }
    
    public function emailValidate($email)
    {
        if (empty($email)) {
            $this->addError("email", "You can't leave the email field empty!");
            return false;
        } else {
            $sanitize = new Sanitize;
            $email = $sanitize->sanitize($email);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->addError('email', "Please provide a valid email address!");
                return false;
            }
            return $email;
        }
    }
    
    public function passwordValidate($password)
    {
        $sanitize = new Sanitize;
    
        if (empty($password)) {
            $this->addError('password', "Please provide a password!");
            return false;
        } elseif (strlen($password) < 4) {
            $this->addError("password", "Please provide a password longer than 4 characters!");
            return false;
        }
        return $sanitize->sanitize($password);
    }
    

    public function addError($field, $error)  
    {
        $this->errors[$field] = $error;
    }

    public function getError($field = null)  
    {
        return $this->errors[$field] ?? [];
    }

    public function hasErrors($field = null) : bool 
    {
        if ($field) {
            return !empty($this->errors[$field]);
        }
        return !empty($this->errors);
    }
}
