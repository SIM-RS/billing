<?php

include "./AuthModel.php";

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$auth = new Auth_model;

$request_data = json_decode(file_get_contents("php://input"), true);

if(!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] != 'POST'){
    http_response_code(401);
    echo json_encode([
        "metadata" => [
            'message' => 'Request method invalid.',
            'code' => 401
        ]
    ]);
    return;
}

if(!isset($request_data['username']) || !isset($request_data['password'])){
    http_response_code(401);
    echo json_encode([
        "metadata" => [
            'message' => 'Invalid request parameter.',
            'code' => 401
        ]
    ]);
    return;
}
$response = $auth->validateUser($request_data['username'], $request_data['password']);
http_response_code($response['metadata']['code']);
echo json_encode($response);