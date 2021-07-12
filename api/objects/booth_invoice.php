<?php

    class BoothInvoice{

        private $conn;
        private $table_name = "booth_invoice";

        public $id;
        public $booth_id;
        public $customer;
        public $duration;
        public $fees;

        public function __construct($db_con){
            $this->conn = $db_con;
        }

        public function getAll(){
            $query = "SELECT * FROM $this->table_name order by id desc";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }

        public function getById(){
            $query = "SELECT * FROM $this->table_name WHERE id=:id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute(['id'=>$this->id]);
            return $stmt;
        }

        public function create(){
            $query = "INSERT INTO $this->table_name (booth_id, customer, duration, fees) VALUES(:booth_id, :customer, :duration, :fees)";
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute(['booth_id'=>$this->booth_id, 'customer'=>$this->customer, 'duration'=>$this->duration, 'fees'=>$this->fees]);
            return $result;
        }

        public function delete(){
            $query = "DELETE FROM $this->table_name WHERE id=:id";
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute(['id'=>$this->id]);
            return $result;
        }

    }

?>