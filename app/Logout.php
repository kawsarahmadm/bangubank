<?php
namespace App;

class Logout
{
    public function logoutCustomer()  
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit;
    }
    public function logoutAdmin()  
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit;
    }
}