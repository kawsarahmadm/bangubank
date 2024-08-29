<?php
require __DIR__ .'../vendor/autoload.php';

use App\Admin;
$adminRegistration = new Admin();
$adminRegistration->run();
