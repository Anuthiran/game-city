<?php

    class Database {
        private $host = "localhost";
        // private $db_name = "tianbui_wp_kpxu8";
        private $db_name = "game_city";
        private $username = "root";
        // private $password = "@pA!5Zr&40sQuK0M";
        private $password = "";
        public $conn;

        public function getConnection(){
            $this->conn = null;
            try{
                $this->conn = new PDO("mysql:host=". $this->host .";dbname=". $this->db_name, $this->username, $this->password);
                // echo "Connected";
            } catch(PDOException $exception){
                echo "Connection Error : ".$exception->getMessage();
            }
            return $this->conn;
        }

    }

?>