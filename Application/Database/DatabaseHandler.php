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
    
    }

 
    public function connectDB($CONFIG)
    {
        try
        {
            $this->Db = new mysqli($CONFIG["servername"], $CONFIG["username"],$CONFIG["password"],$CONFIG["db"]);
            
        }
        catch (mysqli_sql_exception $e)
        {
            trigger_error("Could not connect to database: " . $e->getMessage(), E_USER_ERROR);
        }
    }
}
