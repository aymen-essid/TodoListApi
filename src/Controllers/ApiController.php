<?php 

namespace App\Controllers;

use App\Entity\Task;
use App\Service\DbConnect;
use App\Service\TaskManager;
use DateTime;
use PDO;

class ApiController extends AbstractController
{

    private TaskManager $taskManager;
    
    public function __construct()
    {
        $this->taskManager = new TaskManager();

        // get url params
        // $this->getUrlParams()->entity
    }

    
    public function list(){

        $data = $this->taskManager->getAll();

        $this->jsonHttpResponse('200', $data);
    }

    public function create(){
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $json = file_get_contents("php://input");
            $data = json_decode($json);
  
            $task = new Task;
            $task->setTitle($data->title);
            $task->setDescription($data->description);
            $task->setParentId($data->parentId);
            $task->setCompleted($data->completed);
            $task->setCreatedAt(new DateTime());
            $task->setUpdatedAt(new DateTime());

            

            $insertedId = $this->taskManager->create($task);
            $task->setId($insertedId);

            return $this->jsonHttpResponse('200', $task->serialize() );
        }
        
        // $data = $this->taskManager->create($task);

        $this->jsonHttpResponse('200', "{0 : 'create', 1 : '".$this->getUrlParams()->entity."'}" );
    }
    
    public function add(){

        echo "<h1>add method user entity</h1>";
    }

    
}
