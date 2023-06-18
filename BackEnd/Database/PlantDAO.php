<?php
include_once "Database.php";  

class PlantDAO
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

      public function createPlant($plant): void
   {
    try {
        $email = $user->getEmail();
        $username = $user->getUsername();
        $password = $user->getPassword();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("INSERT INTO plants (email, username, password_hash) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $username, $hashedPassword);
        $stmt->execute();

    } catch (PDOException $e) {
        trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
    }
    
    }
 
}
?>
