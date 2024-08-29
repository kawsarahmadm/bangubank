<?php
require __DIR__ .'/vendor/autoload.php';

use App\Auth;
use App\Logout;

    Auth::isNotLoggedIn();    

    $logout = new Logout();
    $logout->logoutCustomer();
    $logout->logoutAdmin();


