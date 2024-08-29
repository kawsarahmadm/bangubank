<?php
namespace App\Storage;

use App\Validation;
use PDO;


class DatabaseStorage 
{
    private $pdo;
    private $validation;

    public function __construct($config) {
        $this->validation = new Validation;
        $dsn = 'mysql:host='.$config['database']['host'].';dbname='.$config['database']['dbname'].';charset=utf8mb4';

        try {
            $this->pdo = new PDO($dsn, $config['database']['username'], $config['database']['password']);
            // Set the PDO error mode to exception
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw new \Exception("Database connection failed: ". $e->getMessage());
        }
    }
    public function getPDO(): PDO {
        return $this->pdo;
    }

    public function closeConnection(): void {
        $this->pdo = null;
    }

    public function saveData(array $accountData) {
        
        // Prepare the SQL query
        $sql = "INSERT INTO `users` (`name`, `email`, `password`, `account_no`, `role`) VALUES (:name, :email, :password, :account_no, :role)";
        
        try {
            $pdo = $this->getPDO();
            $stmt = $pdo->prepare($sql);

        
            $stmt->execute([
                ':name' => $accountData['name'],
                ':email' => $accountData['email'],
                ':password' => $accountData['password'],
                ':account_no' => $accountData['account_no'],
                ':role' => $accountData['role'],
            ]);

            return $pdo->lastInsertId();
        } catch (\Throwable $e) {
            throw new \Exception("Not Registered. Error: {$e->getMessage()}");
        }
    }

    public function loadData(string $tableName, array $conditions = []) {
        $sql = "SELECT * FROM $tableName";
    
        if (!empty($conditions)) {
            $conditionClauses = [];
            foreach ($conditions as $key => $value) {
                $conditionClauses[] = "$key = :$key";
            }
            $sql .= " WHERE " . implode(" AND ", $conditionClauses);
        }
    
        $stmt = $this->pdo->prepare($sql);
        foreach ($conditions as $key => &$value) {
            $stmt->bindParam(':' . $key, $value);
        }
    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function login(string $email, string $password): bool {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // var_dump($user);
        if ($user && password_verify($password, $user['password']) && $user['role'] == 'customer') {
            echo 'Login successful';
            $_SESSION['email'] = $email;
            header('Location: customer/dashboard.php');
            exit;
        }else{
            $this->validation->addError('auth_error',"Email or Password is not valid");
        }

        // Login failed
        return false;
    }
    public function saveTransactionData(array $data) {
        if (empty($data['account']) || empty($data['toAccount'])) {
            throw new \Exception('Account email cannot be empty.');
        }
    
        $sql = "INSERT INTO transactions (name, amount, date, type, account, toAccount) 
                VALUES (:name, :amount, :date, :type, :account, :toAccount)";
        
        $stmt = $this->pdo->prepare($sql);
    
        // Bind the parameters
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':amount', $data['amount']);
        $stmt->bindParam(':date', $data['date']);
        $stmt->bindParam(':type', $data['type']);
        $stmt->bindParam(':account', $data['account']);
        $stmt->bindParam(':toAccount', $data['toAccount']);
    
        // Execute the statement
        if ($stmt->execute()) {
            return true;
        } else {
            throw new \Exception("Not Successful. Error: " . implode(", ", $stmt->errorInfo()));
        }
    }
    
    

    public function getAllByPropertyName()  {
        
    }

}
?>
