<?php
namespace App\Helpers;


class Sanitize
{
    public function sanitize(string $data) : string 
    {
        return htmlspecialchars(stripslashes(trim($data)));
    }
}