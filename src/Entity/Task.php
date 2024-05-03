<?php

namespace App\Entity;


use App\Service\ApiInterface;
use DateTime;

Class Task implements ApiInterface
{
    private int $id;
    private int $parentId;
    private string $title;
    private string $description;
    private DateTime $createdAt;
    private DateTime $updatedAt;
    private bool $completed;


    public function serialize() : array 
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'parentId' => $this->getParentId(),
            'completed' => $this->getCompleted(),
            'createdAt' => $this->getCreatedAt()->format('d-m-Y H:i:s'),
            'updatedAt' => $this->getUpdatedAt()->format('d-m-Y H:i:s')
        ];
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
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of updatedAt
     */ 
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @return  self
     */ 
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

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

    public function isChild() : int
    {
        if($this->getParentId())
            return true;
        else
            return false;
    }

}