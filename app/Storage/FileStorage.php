<?php
namespace App\Storage;
use App\Validation;

class FileStorage 
{
    private $path;
    public function __construct($config) {
        $this->path =  $config['file']['path'];
    }

    public function saveData(array $data, string $filename): bool 
    {
        $filePath = $this->path . $filename;

        $existingData = [];
        if (file_exists($filePath)) {
            $existingData = json_decode(file_get_contents($filePath), true) ?? [];
        }

        // Append the new data to the existing data
        $existingData[] = $data;
        $jsonData = json_encode($existingData, JSON_PRETTY_PRINT);

        $result = file_put_contents($filePath, $jsonData);
        return $result !== false;
    }
  
    public function loadData(string $filename) {
        $filePath = $this->path . $filename;
        
       $data = file_get_contents($filePath) ?? [];
       return $jsonData = json_decode($data, true) ?? [];
    }

    public function getAllByPropertyName( array $arr, string $property ): array
    {
        return array_column( $arr, $property );
    }

    public  function generateId(string $filename): int
    {    
        if ( !$this->getAllByPropertyName( $this->loadData($filename), "id" ) ) {
            return 1;
        }
        $maxId = max( $this->getAllByPropertyName($this->loadData($filename), "id" ) );
        return $maxId + 1;
    }

    // public function login($email, $password) 
    // {
       
        
    // }
}
