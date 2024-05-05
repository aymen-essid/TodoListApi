<?php 

namespace App\Controllers;

use App\Entity\Task;
use App\Service\TaskManager;
use DateTime;

class ApiController extends AbstractController
{

    private TaskManager $taskManager;
    
    public function __construct()
    {
        parent::__construct();
        $this->taskManager = new TaskManager();
    }

    public function list(){

        if($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            $data = $this->taskManager->getAll();

            $this->api->jsonHttpResponse('200', $data);
        }
    }

    public function create(){

        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $requestJson = file_get_contents("php://input");
            $request = json_decode($requestJson, true);

            $title = isset($request['title']) ? trim($request['title']) : null;
            $description = isset($request['description']) ? trim($request['description']) : null;
            $completed = isset($request['completed']) ? (int) $request['completed'] : 0;
            $parentId = isset($request['parentId']) ? (int) $request['parentId'] : null;
            
            
            if (!$title) {
                return ['message' => 'Please enter a title for the task.'];
            }
            $task = new Task(null, $title, $description, $completed, $parentId, new DateTime() );
            $lastId = $this->taskManager->create($task);
            $task->setId($lastId);
            
            return $this->api->jsonHttpResponse('200', $task->jsonSerialize() );
        }

    }
    
    public function update(){

        if($_SERVER['REQUEST_METHOD'] === 'PUT' )
        {
            $requestJson = file_get_contents("php://input");
            $request = json_decode($requestJson, true);
            
            if($id = $request['id'] ){

                $task = $this->taskManager->getTaskById($id);

                $title = isset($request['title']) ? trim($request['title']) : $task->getTitle();
                $description = isset($request['description']) ? trim($request['description']) : $task->getDescription();
                $completed = isset($request['completed']) ? (int) $request['completed'] : $task->getCompleted();
                $parentId = isset($request['parentId']) ? (int) $request['parentId'] : $task->getParentId();
                

                if($title) 
                    $task->setTitle($title);
                if($description) 
                    $task->setDescription($description);
                if($completed) 
                    $task->setCompleted($completed);
                if($parentId) 
                    $task->setParentId($parentId);

                if($this->taskManager->update($task))
                    return $this->api->jsonHttpResponse('200', $task );
                else 
                    return $this->api->jsonHttpResponse('500', 'Problem update' );
            }
            
        }

        $this->api->jsonHttpResponse('200', "{0 : 'create', 1 : '".$this->getUrlParams()->entity."'}" );
    }


    public function delete() : bool {
        if($_SERVER['REQUEST_METHOD'] === 'DELETE' )
        {
            $requestJson = file_get_contents("php://input");
            $request = json_decode($requestJson, true);
            
            if($id = $request['id'] ){
                $task = $this->taskManager->getTaskById($id);
                
                if($this->taskManager->delete($task))
                    return true;
            }
        }
        return false;
    }

    
}
