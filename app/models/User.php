<?php 

class User{
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function register($username, $email, $password){
        $passwordHashed = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (username, email, password) VALUES (?,?,?)";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([$username, $email, $passwordHashed]);
    }

    public function login($email, $password){
        $query = "SELECT * FROM users WHERE email = ?";        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if($user && password_verify($password, $user['password'])){
            return $user;
        }
        return false;
    }

    public function emailExists($email){
        $query = "SELECT id FROM users WHERE email = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$email]);
        return $stmt->fetch() ? true : false;
    }

    public function userNameExists($userName){
        $query = "SELECT id FROM users WHERE username = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$userName]);
        return $stmt->fetch() ? true : false;
    }
}