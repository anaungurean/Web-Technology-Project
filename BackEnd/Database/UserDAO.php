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
            $password = null;
            $statement->bind_result($id, $email, $username, $password);
            $statement->fetch();
            return new User($email, $username, $password);
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
            return true; // Utilizatorul există deja
        } else {
            return false; // Utilizatorul nu există
        }
    }




    public function checkLogin($username, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);

        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            // Parola este corectă
            return true;
        } else {
            // Autentificare eșuată
            return false;
        }
    }

}
?>
