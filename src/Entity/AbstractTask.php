<?php

namespace App\Entity;

abstract class AbstractTask implements TaskInterface
{
    private $id;
    private $title;
    private $description;
    private $completed;
    private $createdAt;
    private $updatedAt;
}