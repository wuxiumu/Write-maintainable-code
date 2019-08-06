<?php

class Db
{
    private static $instance;
    private $db;
    const HOSTNAME = "127.0.0.1";
    const USERNAME = "root";
    const PASSWORD = "123456";
    const DBNAME = "haha";

    private function __construct(){
        $this->db = mysqli_connect(
                                self::HOSTNAME, 
                                self::USERNAME, 
                                self::PASSWORD, 
                                self::DBNAME);
    }

    private function __clone(){}

    public static function getInstance(){
        if(!(self::$instance instanceof self)){
            self::$instance = new self();
        }
        return self::$instance;
    }   
    
    public function getinfo(){
        $sql = "select * from haha";
        $res = mysqli_query($this->db,$sql);
        while($row = mysqli_fetch_array($res)) {
            echo $row['name'] . '<br />';
        }
        mysqli_free_result($res);
    }
}

$mysqli = DB::getInstance();
$mysqli->getinfo($sql);
