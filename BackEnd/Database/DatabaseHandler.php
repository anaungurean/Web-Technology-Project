<?php
 class DatabaseConnection
{
    private static $instance;
    private $connection;

    private function __construct()
    {
        // Perform the database connection here
        $this->connection = new PDO("mysql:host=localhost;dbname=webdb", "root", "");
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new DatabaseConnection();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
?>
