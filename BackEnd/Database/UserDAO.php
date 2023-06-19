<?php
include_once "Database.php";  

class UserDAO
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

   public function createUser($user): void
   {
    try {
        $email = $user->getEmail();
        $username = $user->getUsername();
        $password = $user->getPassword();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("INSERT INTO users (email, username, password_hash) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $username, $hashedPassword);
        $stmt->execute();

    } catch (PDOException $e) {
        trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
    }
    
    }



    public function updateUser($user): void
    {
        try {
            $id = $user->getId();
            // $email = $user->getEmail();
            // $username = $user->getUsername();
            // $password = $user->getPassword();
            // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $descriere = $user->getDescription();
            $hobby = $user->getHobby();
            $interes_plant = $user->getInteresPlant();
            $firstname = $user->getFirstname();
            $lastname = $user->getLastname();
            $phone = $user->getPhone();
            $adresa = $user->getAddress();


            $stmt = $this->conn->prepare("UPDATE users SET descriere = ?, hobby = ?, interes_plant = ?, firstname = ?, lastname = ?, phone = ?, adresa = ? WHERE id = ?");
            $stmt->bind_param("sssssssi", $descriere, $hobby, $interes_plant, $firstname, $lastname, $phone, $adresa, $id);
            $stmt->execute();
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
        }
    }


    public function findById($id)
    {
        try {
            $statement = $this->conn->prepare("SELECT id, email, username, password_hash FROM users WHERE id = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
            $statement->store_result();
            $id = null;
            $email = null;
            $username = null;
            $password_hash = null;
            $statement->bind_result($id, $email, $username, $password_hash);
            $statement->fetch();
            $user = new User();
            $user->setEmail($email);
            $user->setUsername($username);
            
            $user->setPassword($password_hash);
            return $user;
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function findUser($id)
    {
        try {
            $statement = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
            $statement->store_result();
            $id = null;
            $email = null;
            $username = null;
            $password_hash = null;
            $descriere = null;
            $hobby = null;
            $interes_plant = null;
            $firstname = null;
            $lastname = null;
            $phone = null;
            $adresa = null;
            $statement->bind_result($id, $email, $username, $password_hash, $descriere, $hobby, $interes_plant, $firstname, $lastname, $phone, $adresa);
            $statement->fetch();
            $user = new User();
            $user->setId($id);
            $user->setEmail($email);
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPassword($password_hash);
            $user->setDescription($descriere);
            $user->setHobby($hobby);
            $user->setInteresPlant($interes_plant);
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setPhone($phone);
            $user->setAddress($adresa);
            
            return $user;
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
        }
    }


   public function findByUsername($username)
{
    try {
        $statement = $this->conn->prepare("SELECT id, email, username, password_hash FROM users WHERE username = ?");
        $statement->bind_param("s", $username);
        $statement->execute();
        $statement->store_result();
        $count = $statement->num_rows;
        $statement->close();
        return ($count > 0);
    } catch (PDOException $e) {
        trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
    }
}

public function findByUsernameAndPassword($username, $password)
{
    try {
        $statement = $this->conn->prepare("SELECT id, email, username, password_hash FROM users WHERE username = ?");
        $statement->bind_param("s", $username);
        $statement->execute();
        $result = $statement->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password_hash'])) {
             return $user['id'];
        } else {
             return -1;
        }
    } catch (PDOException $e) {
        trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
    }
}


public function findByEmail($email)
{
    try {
        $statement = $this->conn->prepare("SELECT id, email, username, password_hash FROM users WHERE email = ?");
        $statement->bind_param("s", $email);
        $statement->execute();
        $statement->store_result();
        $count = $statement->num_rows;
        $statement->close();
        return ($count > 0);
    } catch (PDOException $e) {
        trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
    }
}


    public function checkExistingUser($email, $username): bool
    {
        $existingUserByEmail = $this->findByEmail($email);
        $existingUserByUsername = $this->findByUsername($username);
    
        if ($existingUserByEmail || $existingUserByUsername ) {
            return true; 
        } else {
            return false;  
        }
    }



  public function checkLogin($username, $password)
{
    $existingIdUser = $this->findByUsernameAndPassword($username, $password);
    return $existingIdUser;
     
}

}
?>
