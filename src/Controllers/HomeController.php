<?php

namespace App\Controllers;

use App\Entity\Task;
use DateTime;

class HomeController extends AbstractController
{
    

    public function index(){

        $task = new Task();
        $task->setId(1);
        $task->setTitle('task title');
        $task->setDescription('Description text');
        $task->setCompleted(0);
        $task->setParentId(1);
        $task->setCreatedAt(new DateTime());
        $task->setUpdatedAt(new DateTime());


        $this->jsonHttpResponse('200', $task->serialize() );

        die;

        $this->render('home.html.twig');
    }

    public function action(){

        echo "<h1>Action method</h1>";
    }

}
