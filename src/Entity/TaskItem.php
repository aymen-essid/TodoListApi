<?php

namespace App\Entity;

use App\Entity\AbstractTask;

Class TaskItem extends AbstractTask
{
    private $Completed;
    private $hasParent;



    #getters & setters : TODO

    public function hasParent() : int
    {

        return 1;
    }

    public function isCompleted(): bool
    {
        
        return true;
    }
}