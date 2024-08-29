<!-- <?php
namespace App;

use DateTime;
use DateTimeZone;

class Transition
{
    private $name;
    private $amount;
    private $date;
    private $transitionType;
    private $toAccount;
    private $account;


    public function __construct($name, $amount, $transitionType,  $account, $toAccount ) {
        $this->name = $name;
        $this->amount = $amount;
        $this->transitionType = $transitionType;
        $this->account = $account;
        $this->toAccount = $toAccount;
        $this->date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
    }
    
    public function getName() {
        return $this->name;
    }
    public function getAmount() {
        return $this->amount;
    }
    public function getDate() {
        return $this->date;
    }

    public function getTransitionType() {
        return $this->transitionType;
    }

    public function getToAccount() {
        return $this->toAccount;
    }

    public function getAccount() {
        return $this->account;
    }
   
    
    
    
}
?> -->
