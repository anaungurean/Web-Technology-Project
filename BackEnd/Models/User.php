<?php

class User implements JsonSerializable
{
    private $id;
    private $email;
    private $username;
    private $password;
    private $descriere;
    private $hobby;
    private $interes_plant;
    private $firstname;
    private $lastname;
    private $phone;
    private $adresa;


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


    public function setDescription($descriere): void
    {
        $this->descriere = $descriere;
    }

    public function getDescription()
    {
        return $this->descriere;
    }


    public function setHobby($hobby): void
    {
        $this->hobby = $hobby;
    }

    public function getHobby()
    {
        return $this->hobby;
    }

    public function setInteresPlant($interes_plant): void
    {
        $this->interes_plant = $interes_plant;
    }

    public function getInteresPlant()
    {
        return $this->interes_plant;
    }

    public function setFirstname($firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setLastname($lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setAddress($adresa): void
    {
        $this->adresa = $adresa;
    }

    public function getAddress()
    {
        return $this->adresa;
    }


    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'username' => $this->username,
            'password' => $this->password,
            'descriere' => $this->descriere,
            'hobby' => $this->hobby,
            'interes_plant' => $this->interes_plant,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'phone' => $this->phone,
            'adresa' => $this->adresa,
        ];
    }

    public function __toString(): string
    {
        return "User: " . $this->id . " " . $this->email . " " . $this->username . " " . $this->password . " " . $this->descriere . " " . $this->hobby . " " . $this->interes_plant . " " . $this->firstname . " " . $this->lastname . " " . $this->phone . " " . $this->adresa;
    }

   
}
?>
