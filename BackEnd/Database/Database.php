<?php
 class Database
{
    private static $instance;
    private $conn;

    private function __construct()
    {
        // Perform the database connection here
        $this->conn = new mysqli('localhost', 'root','', 'webdb');

    if (!$this->conn) {
        trigger_error("Could not connect to database: " . mysqli_connect_error(), E_USER_ERROR);
    }
}

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
?>
