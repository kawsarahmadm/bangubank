<?php

namespace App\Storage;

interface StorageInterface
{
    public function saveData(array $data,  string $filename);
    public function loadData(string $filename);
}