<?php

    class GameBooth{

        private $conn;
        private $table_name = "game_booth";

        public $id;
        public $boothname;
        public $price;
        public $feature;
		public $image_name;

        public function __construct($db_con){
            $this->conn = $db_con;
        }

        public function getAll(){
            $query = "SELECT * FROM $this->table_name";
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
            $query = "INSERT INTO $this->table_name (boothname, price, feature, image_name) VALUES(:boothname, :price, :feature, :image_name)";
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute(['boothname'=>$this->boothname, 'price'=>$this->price, 'feature'=>$this->feature, 'image_name'=>$this->image_name]);
            return $stmt;
        }

        public function delete(){
            $query = "DELETE FROM $this->table_name WHERE id=:id";
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute(['id'=>$this->id]);
            return $result;
        }

        public function checkGameBoothExits($boothname){
            $query = "SELECT * FROM $this->table_name WHERE boothname=:boothname";
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute(['boothname'=>$boothname]);
            $count = $stmt->rowCount();
            if($count>0){
                return true;
            }
            return false;
        }

        public function update(){
            $query = "UPDATE $this->table_name SET boothname=:boothname, price=:price, feature=:feature, image_name=:image_name WHERE id=:id";
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute(['boothname'=>$this->boothname, 'price'=>$this->price, 'feature'=>$this->feature, 'image_name'=>$this->image_name, 'id'=>$this->id]);
            return $result;
        }

    }

?>