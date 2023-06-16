<?php

class DatabaseHandler
{
    private $CONFIG;
    private $Db;
    
    public function __construct()
    {

    }

    public function __destruct()
    {
    if ($this->Db) {
        $this->Db->close();
        echo "Connection to DB closed";
    }
     }

 
    public function connectDB($CONFIG)
    {
        try
        {
            $this->Db = new mysqli($CONFIG["servername"], $CONFIG["username"],$CONFIG["password"],$CONFIG["db"]);
            
            if (!$this->Db) {
                echo "Not connected to DB";
            } else {
                echo "Successfully connected to DB";
            }
        }
        catch (mysqli_sql_exception $e)
        {
            trigger_error("Could not connect to database: " . $e->getMessage(), E_USER_ERROR);
        }
    }
}
