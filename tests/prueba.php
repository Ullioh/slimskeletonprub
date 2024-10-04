<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Origin, token, x-requested-with, Content-Type, Accept, cache-control');

    // $data = json_decode(file_get_contents('php://input'), true);
    $data = $_POST;
    echo json_encode($data);
?>