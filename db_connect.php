<?php
class db_connect
{
    public $dbName = "map_db";
    public $serverName = "localhost";
    public $userName = "root";
    public $password = "";

    function connect()
    {
        try {
            $conn = new PDO("mysql:host=" . $this->serverName . ";dbname=" . $this->dbName, $this->userName, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo    "<script>
                        alert(Connection failed: " . $e->getMessage() . "); 
                    </script>";
        }
    }
}
