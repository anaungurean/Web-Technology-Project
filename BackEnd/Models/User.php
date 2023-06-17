<?php

class User implements JsonSerializable
{
    private $id;
    private $email;
    private $username;
    private $password;

      public function __construct( )
    {
        
    }
    public function getId()
    {
        return $this->id;
    }

    // setter for id
    public function setId($id): void
    {
        $this->id = $id;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setUsername($username): void
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'username' => $this->username,
            'password' => $this->password,
        ];
    }

    public function __toString(): string
    {
        return "User: " . $this->id . " " . $this->email . " " . $this->username . " " . $this->password;
    }

   
}
?>
