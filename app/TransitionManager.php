<!-- <?php
namespace App;
use App\FileHandler;
use App\Transition;

class TransitionManager
{
    private $fileHandler;
    private $validation;
    public function __construct(FileHandler $fileHandler, Validation  $validation) {
        $this->fileHandler = $fileHandler;
        $this->validation = $validation;
    }

    public function depositMoney(Transition $transition) 
    {      
        $transitionData = array(
            "name" => $transition->getName(),
            "amount"=> (int) $transition->getAmount(),
            "date"=> $transition->getDate()->format('Y-m-d, h:i:s A'),
            "transitionType"=> $transition->getTransitionType(),
            "account"=> $transition->getAccount(),
            "toAccount"=> $transition->getToAccount(),
        );

        if ($this->fileHandler->saveData($transitionData)) {
            return true;
        }else{
            $this->validation->addError('auth_error',"failed to add transition data! please try again!");
            return false;
        }
    }
    public function withdrawMoney(Transition $transition) 
    {
        
        $transitionData = array(
            "name" => $transition->getName(),
            "amount"=> (int) $transition->getAmount(),
            "date"=> $transition->getDate()->format('Y-m-d, h:i:s A'),
            "transitionType"=> $transition->getTransitionType(),
            "account"=> $transition->getAccount(),
            "toAccount"=> $transition->getToAccount(),
        );

        if ($this->fileHandler->saveData($transitionData)) {
            return true;
        }else{
            $this->validation->addError('auth_error',"failed to add transition data! please try again!");
            return false;
        }
    }
    public function transferMoney(Transition $transition) 
    {
        
        $transitionData = array(
            "name" => $transition->getName(),
            "amount"=> (int) $transition->getAmount(),
            "date"=> $transition->getDate()->format('Y-m-d, h:i:s A'),
            "transitionType"=> $transition->getTransitionType(),
            "account"=> $transition->getAccount(),
            "toAccount"=> $transition->getToAccount(),
        );

        if ($this->fileHandler->saveData($transitionData)) {
            return true;
        }else{
            $this->validation->addError('auth_error',"failed to add transition data! please try again!");
            return false;
        }
    }

} -->