<?php

namespace App\Service;

use App\Entity\Task;
use DateTime;
use PDO;

class TaskManager
{
    private $db;

    // Constructor
    public function __construct() {
        $initDb = new DbHandler();
        $this->db = $initDb->connect();
    }

    // Create a new task item
    public function create(Task $task) {
        $sql = "INSERT INTO task (title, description, completed, parentId, createdAt) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $now = new DateTime();
        $stmt->execute([$task->getTitle(), $task->getDescription(), $task->getCompleted(),
                        $task->getParentId(), $now->format('Y-m-d H:i:s')]);
        return $this->db->lastInsertId();
    }

    // Read a task item by ID
    public function getAll() {
        $sql = "SELECT * FROM task";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Read a task item by ID
    public function getTaskById(int $id) {
        $sql = "SELECT * FROM task WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Update a task item
    public function update($data) {
    
        $sql = "UPDATE task 
                SET title = ?, description = ?, completed = ?, parentId = ?, updatedAt = ?
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $now = new DateTime();
        $stmt->execute([$data['title'], $data['description'], $data['completed'],
                        $data['parentId'], $now->format('Y-m-d H:i:s'), $data['id']]);
        return $stmt->rowCount() > 0;
    }

    // Delete a task item
    public function delete($id) {
        $sql = "DELETE FROM task WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }

    public function arrayToTaskObject(array $data)
    {
        $task = new Task;
        $task->setTitle($data['title']);
        $task->setDescription($data['description']);
        $task->setParentId($data['parentId']);
        $task->setCompleted($data['completed']);
        $task->setCreatedAt(new DateTime());

        return $task;
    }

}