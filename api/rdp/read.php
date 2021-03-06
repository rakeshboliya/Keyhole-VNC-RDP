<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
include_once '../config/database.php';
include_once '../objects/rdp.php';
 
$database = new Database();
$db = $database->getConnection();
 
$rdp = new Rdp($db);
 
$stmt = $rdp->read();
$num = $stmt->rowCount();
 
if($num>0){
 
    $rdps_arr=array();
    $rdps_arr["records"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $rdp_item=array(
            "id" => $id,
            "ip" => $ip,
            "port" => $port,
            "asn" => $asn,
            "isp" => $isp,
            "city" => $city,
            "region_code" => $region_code,
            "area_code" => $area_code,
            "country_code" => $country_code,
            "postal_code" => $postal_code,
            "country_name" => $country_name,
            "latitude" => $latitude,
            "longitude" => $longitude,
            "timestamp" => $timestamp,
            "org" => $org,
            "mime" => $mime,
            "image_data" => $image_data
        );
 
        array_push($rdps_arr["records"], $rdp_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($rdps_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No rdps found.")
    );
}