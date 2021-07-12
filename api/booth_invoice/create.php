<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

    include_once '../config/database.php';
    include_once '../objects/booth_invoice.php';

    $database = new Database();
    $db_connection = $database->getConnection();

    $booth_invoice = new BoothInvoice($db_connection);
	$folderPath = "upload/";
	
    $data = json_decode(file_get_contents("php://input"));

    if( !empty($data->booth_id) && !empty($data->customer) && !empty($data->duration) && !empty($data->image_name) ) {
        $booth_invoice->booth_id = $data->booth_id;
        $booth_invoice->customer = $data->customer;
        $booth_invoice->duration = $data->duration;
        $booth_invoice->fees = $data->fees;
	
        if($game_booth->create()){
			http_response_code(200);
			echo json_encode(array("message"=>"booth_invoice was created", "status"=>"200"));
		} else{
			http_response_code(503);
			echo json_encode(array("message"=>"Unable to create booth_invoice"));
		} 
    } else{
        http_response_code(400);
        echo json_encode(array("message"=>"Unable to create booth_invoice. Data is incomplete."));
    }


?>