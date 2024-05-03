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
            $json = file_get_contents("php://input");

            $task = new Task();
            $task = $task->deserialize($json);

            $insertedId = $this->taskManager->create($task);
            $task->setId($insertedId);
            $task = $this->taskManager->getTaskById($insertedId);
            

            return $this->api->jsonHttpResponse('200', $task );
        }

    }
    
    public function update(){

        if($_SERVER['REQUEST_METHOD'] === 'PUT' )
        {
            $json = file_get_contents("php://input");
            $jsonObj = json_decode($json); 
            
            $taskObj = $this->taskManager->getTaskById($jsonObj->id);
            
            dd($taskObj);
            

            return $this->api->jsonHttpResponse('200', '' );
            
        }

        $this->api->jsonHttpResponse('200', "{0 : 'create', 1 : '".$this->getUrlParams()->entity."'}" );
    }

    
}
