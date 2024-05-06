<?php

namespace App\Entity;

use App\Service\JsonSerializableInterface;

Class Task implements JsonSerializableInterface
{
    private int $id;
    private int $parentId;
    private string $title;
    private string $description;
    private bool $completed;

    public function __construct(
        int $id=null,  
        string $title=null, 
        string $description=null, 
        bool $completed=null, 
        int $parentId=null
        ) 
    {
        $this->setId((int) $id);
        $this->setParentId((int) $parentId);
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setCompleted($completed);
    }
    

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of parentId
     */ 
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set the value of parentId
     *
     * @return  self
     */ 
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }


    /**
     * Get the value of Completed
     */ 
    public function getCompleted()
    {
        return $this->completed;
    }

    /**
     * Set the value of Completed
     *
     * @return  self
     */ 
    public function setCompleted($completed)
    {
        $this->completed = $completed;

        return $this;
    }

    public function jsonSerialize() : mixed 
    {
        return [
          'id' => $this->getId(),
          'title' => $this->getTitle(),
          'description' => $this->getDescription(),
          'completed' => $this->getCompleted(),
          'parentId' => $this->getParentId() . " - title parent", // TODO fetch title parent Task
        ];
    }

}