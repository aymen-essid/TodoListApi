<?php

namespace App\Controllers;

use App\Entity\Task;
use App\Service\TaskManager;
use DateTime;

class HomeController extends AbstractController
{

    private TaskManager $taskManager;
    
    public function __construct()
    {
        parent::__construct();
        $this->taskManager = new TaskManager();
    }

    public function index(){

        $this->isAuthorized();
        
        $taskList = $this->taskManager->getAll();
        // dd($taskList);
        $this->render('home.html.twig', [
            'taskList' => $taskList
        ]);
    }

}
