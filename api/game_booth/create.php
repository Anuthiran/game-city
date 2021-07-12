<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	// header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

    include_once '../config/database.php';
    include_once '../objects/game_booth.php';

    $database = new Database();
    $db_connection = $database->getConnection();

    $game_booth = new GameBooth($db_connection);
	$folderPath = "upload/";
	
    $data = json_decode(file_get_contents("php://input"));

    if( !empty($data->boothname) && !empty($data->price) && !empty($data->feature) && !empty($data->image_name) ) {
        $game_booth->boothname = $data->boothname;
        $game_booth->price = $data->price;
        $game_booth->feature = $data->feature;
        
		
		$image_parts = explode(";base64,", $data->fileSource);
		$image_type_aux = explode("image/", $image_parts[0]);
		$image_type = $image_type_aux[1];
		$image_base64 = base64_decode($image_parts[1]);
		
		$x = uniqid() . '.png';
		
		$file = $folderPath . $x;
		
		$game_booth->image_name = $x;
		
		file_put_contents($file, $image_base64);

        $is_exit_email = $game_booth->checkGameBoothExits($data->boothname);

        if($is_exit_email){
            http_response_code(400);
            echo json_encode(array("message"=>"game_booth already exit."));
        } else {
            if($game_booth->create()){
                http_response_code(200);
                echo json_encode(array("message"=>"game_booth was created", "status"=>"200"));
            } else{
                http_response_code(503);
                echo json_encode(array("message"=>"Unable to create game_booth"));
            }
        }   
    } else{
        http_response_code(400);
        echo json_encode(array("message"=>"Unable to create game_booth. Data is incomplete."));
    }


?>