<?php

namespace App\Entity;



Class User
{

    private $id;
    private $username;
    private ?string $password;

    public function __construct(int $id, string $username, ?string $password = null) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }

    public function jsonSerialize() : mixed 
    {
        return [
          'id' => $this->getId(),
          'username' => $this->getUsername(),
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
     * Get the value of username
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */ 
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = md5($password);

        return $this;
    }
}