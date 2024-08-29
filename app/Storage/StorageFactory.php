<?php
namespace App\Storage;

class StorageFactory
{
    public static function getStorage($config) 
    {
        $storageType = $config['storage']['type'];

        switch ($storageType) {
            case 'file':
                return new FileStorage($config);
            case 'database':
                return new DatabaseStorage($config);
            
            default:
                throw new \Exception("Unsupported Storage type: " . $storageType);
        }
    }
}

?>