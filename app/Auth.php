<?php
namespace App;

class Auth
{
    public static function isLoggedIn()  
    {
        session_start();
        if (isset($_SESSION['email'])) {
            header("Location: customer/dashboard.php");
            exit();
        }
    }
    public static function isNotLoggedIn()  
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header("Location: ../index.php");
            exit();
        }
    }
    public static function isAdminLoggedIn()  
    {
        session_start();
        if (isset($_SESSION['email'])) {
            header("Location: admin/customers.php");
            exit();
        }
    }
    public static function isAdminNotLoggedIn()  
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header("Location: ../index.php");
            exit();
        }
    }
}