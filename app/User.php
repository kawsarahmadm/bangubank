<?php
namespace App;

class User
{
    private $name;
    private $email;
    private $password;
    private $transactionId;

    public function __construct($name, $email, $password) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function getName() 
    {
        return $this->name; 
    }
    public function getEmail() 
    {
        return $this->email; 
    }
    public function getPassword() 
    {
        return $this->password; 
    }
    private function generateTransactionId($prefix = '') {
        $randomNum = mt_rand(1000, 9999);
        return $prefix . $randomNum;
    }
    public function getId() {
        return $this->transactionId = $this->generateTransactionId("bbank_");
    }
}
