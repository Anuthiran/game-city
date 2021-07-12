<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../config/database.php';
    include_once '../objects/game_booth.php';

    $database = new Database();
    $db_connection = $database->getConnection();

    $game_booth = new GameBooth($db_connection);

    $statment = $game_booth->getAll();
    $count = $statment->rowCount();

    if($count>0){

        $result_array = array();
        $result_array['status'] = 200;
        $result_array['count'] = $count;
        $result_array['data'] = array();

        while(  $row = $statment->fetch(PDO::FETCH_OBJ)){
            $item = array(
                "id"=>$row->id,
                "boothname"=>$row->boothname,
                "price"=>$row->price,
                "feature"=>$row->feature,
                "image_name"=>$row->image_name
            );
            array_push($result_array['data'], $item);
        }
        http_response_code(200);
        echo json_encode($result_array);
    } else{
        http_response_code(404);
        echo json_encode(array("message" => "No game_booth found.","count" => $count));
    }

?>