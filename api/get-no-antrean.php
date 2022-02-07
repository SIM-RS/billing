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
if (!isset($request_data['nomorkartu']) || !isset($request_data['nik']) || !isset($request_data['notelp']) || !isset($request_data['tanggalperiksa']) || !isset($request_data['kodepoli']) || !isset($request_data['nomorreferensi']) || !isset($request_data['jenisreferensi']) || !isset($request_data['jenisrequest']) || !isset($request_data['polieksekutif'])) {
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
$nomorkartu = $request_data['nomorkartu'];
$nik = $request_data['nik'];
$notelp = $request_data['notelp'];
$tanggalperiksa = $request_data['tanggalperiksa'];
$kodepoli = $request_data['kodepoli'];
$nomorreferensi = $request_data['nomorreferensi'];
$jenisreferensi = $request_data['jenisreferensi'];
$jenisrequest = $request_data['jenisrequest'];
$polieksekutif = $request_data['polieksekutif'];

$response = $antrean_model->simpanAntrianBaru(
                                $nomorkartu, $nik, $notelp, $tanggalperiksa,
                                $kodepoli, $nomorreferensi, $jenisreferensi, 
                                $jenisrequest, $polieksekutif
                            );

http_response_code($response['metadata']['code']);
echo json_encode($response);