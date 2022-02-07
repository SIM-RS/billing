<?php

include_once "./AuthModel.php";
include_once "./antrian_model.php";

$antrean_model = new Antrian_model;
$auth = new Auth_model;

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

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

/**
 * Cek jika token benar
 */
if(($rescod = $auth->isValidToken()) <= 0) {
    $output = [
        "metadata" => [
            "message" => (($rescod == 0) ? "Auth Failed!" : (($rescod == -1) ? "Expired token!" : "Token tidak ada.")),
            "code" => 401
        ]
    ];
    http_response_code(401);
    echo json_encode($output);
    return;
}

/**
 * Filter request parameter
 *  */ 
if (!isset($request_data['nopeserta'])) {
    http_response_code(401);
    echo json_encode([
        "metadata" => [
            'message' => 'Invalid request parameter.',
            'code' => 401
        ]
    ]);
    return;
}

/**
 * Store value
 */
$nomorkartu = $request_data['nopeserta'];

$response = $antrean_model->get_booking_peserta($nomorkartu);

http_response_code($response['metadata']['code']);
echo json_encode($response);