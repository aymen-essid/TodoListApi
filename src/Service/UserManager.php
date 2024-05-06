<?php

namespace App\Service;

use App\Entity\Task;
use App\Entity\User;
use DateTime;
use Exception;
use PDO;

class UserManager
{
    private $db;

    public function __construct() {
        $initDb = new DbHandler();
        $this->db = $initDb->connect();
    }

    public function create(User $user): User 
    {
        // Prepare SQL statement for user insertion
        $sql = "INSERT INTO user (username, password) VALUES (:username, :password)";
        $stmt = $this->db->prepare($sql);

        // Bind parameters with user data (MD5 hash password)
        $stmt->bindValue(':username', $user->getUsername(), PDO::PARAM_STR);
        $stmt->bindValue(':password', md5($user->getPassword()), PDO::PARAM_STR); // **Insecure!** Consider using password_hash()

        // Execute the statement and handle errors
        if ($stmt->execute()) {
            $userId = $this->db->lastInsertId();
            $user->setId($userId);
            return $user;
        } else {
            throw new Exception('Failed to create user: ' . implode(' ', $stmt->errorInfo()));
        }
    }

    public function getAll(): mixed 
    {
        // Prepare SQL statement for user selection by ID
        $sql = "SELECT * FROM user";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $users = [];
        
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] =  new User($result['id'], $result['username'], null); 
        }
        return $users;
    }
    
    public function getUserById(int $id): ?User 
    {
        // Prepare SQL statement for user selection by ID
        $sql = "SELECT * FROM user WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $user = $stmt->fetchObject(User::class);
            return $user;
        } else {
            return null;
        }
    }

    public function getUserByUsername(string $username): ?User 
    {
        // Prepare SQL statement for user selection by username
        $sql = "SELECT * FROM user WHERE username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $user = new User($result['id'], $result['username'], $result['password']);
            return $user;
        } else {
            return null;
        }
    }
    
    public function update(User $user): User 
    {
        // Prepare SQL statement for user update
        $sql = "UPDATE user SET username = :username, password = :password WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        // Bind parameters with user data (MD5 hash password)
        $stmt->bindValue(':username', $user->getUsername(), PDO::PARAM_STR);
        $stmt->bindValue(':password', md5($user->getPassword()), PDO::PARAM_STR); // **Insecure!** Consider using password_hash()
        $stmt->bindValue(':id', $user->getId(), PDO::PARAM_INT);

        // Execute the statement and handle errors
        if ($stmt->execute()) {
            return $user;
        } else {
            throw new Exception('Failed to update user: ' . implode(' ', $stmt->errorInfo()));
        }
    }
    
    public function delete(int $id): bool 
    {
        // Prepare SQL statement for user deletion by ID
        $sql = "DELETE FROM user WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        // Bind parameter with ID
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        // Execute the statement and handle errors
        return $stmt->execute();
    }
}