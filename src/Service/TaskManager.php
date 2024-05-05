<?php

namespace App\Service;

use App\Entity\Task;
use DateTime;
use PDO;

class TaskManager
{
    private $db;

    public function __construct() {
        $initDb = new DbHandler();
        $this->db = $initDb->connect();
    }

    // Create a new task item
    public function create(Task $task) {

        // check if task parent exists
        $parent = $this->getTaskById($task->getParentId());
        if(!$parent)
            $task->setParentId(1); // set default parent

        $sql = "INSERT INTO task ( title, description, completed, parentId)  VALUES  ( :title, :description, :completed, :parentId) ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':title', $task->getTitle());
        $stmt->bindValue(':description', $task->getDescription());
        $stmt->bindValue(':completed', $task->getCompleted(), PDO::PARAM_BOOL);
        $stmt->bindValue(':parentId', $task->getParentId(), PDO::PARAM_INT);

        $stmt->execute();

        return $this->db->lastInsertId();
    }

    // Get all tasks
    public function getAll() {
        $sql = "SELECT * FROM task";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $tasks = [];
        
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $task =  new Task($result['id'], $result['title'], $result['description'], $result['completed'] == 1, $result['parentId']); 
            $tasks[] =  $task->jsonSerialize();
        }
        return $tasks;
    }

    // Get a task by ID
    public function getTaskById(int $id) {
        $sql = "SELECT * FROM task WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return new Task($result['id'], $result['title'], $result['description'], $result['completed'] == 1, $result['parentId']);
        }
        return null;
    }

    // Update a task
    public function update(Task $task) {
    
        $sql = "UPDATE task SET title = :title, description = :description, completed = :completed, parentId = :parentId WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':title', $task->getTitle());
        $stmt->bindValue(':description', $task->getDescription());
        $stmt->bindValue(':completed', $task->getCompleted() ? 1 : 0);
        $stmt->bindValue(':parentId', $task->getParentId());
        $stmt->bindValue(':id', $task->getId());
        
        
        return $stmt->execute();

    }

    // Delete a task
    public function delete(Task $task) {
        $sql = "DELETE FROM task WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $task->getId());
        $stmt->execute();
    }

}