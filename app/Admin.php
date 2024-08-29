<?php
namespace App;
use App\AdminManager;

class Admin
{
    private AdminManager $adminManager;
    private const REGISTER_ADMIN = 1;
    private const EXIT_APP = 2;

    private array $options = [
        self::REGISTER_ADMIN => 'Register Admin',
        self::EXIT_APP => 'Exit'
    ];
  
    public function __construct()  {
        $this->adminManager = new AdminManager();
    }

    public function run()  {
        while (true) {
            foreach ($this->options as $option => $label) {
                printf("%d. %s\n", $option, $label);
            }
            $choice = intval(readline("Enter your option: "));
            switch ($choice) {
                case self::REGISTER_ADMIN:
                    echo "adding admin\n";
                    $this->adminManager->registerAdmin();
                    break;
                
                
                case self::EXIT_APP:
                    return;
                
                default:
                    echo "Invalid option. \n";
            }
        }
    
    }
    
}
