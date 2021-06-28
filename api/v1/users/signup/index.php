<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/api/v1/token/index.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/var/autoload.php';
header('Content-type: application/json');
$email = $_GET['email'];
$password = $_GET['password'];

$res = $db->query("SELECT * FROM `users` WHERE `email` = '$email'");

if ($res->num_rows > 0) {
    echo json_encode([
        "result" => "error",
        "msg" => "User with email $email already exists"
    ]);
} else {
    if (strlen($password) >= 6) {
        $pHash = password_hash($password, PASSWORD_DEFAULT);
        $iframe = generateToken();
        $api = generateToken();
        $db->query("INSERT INTO `users` SET `email` = '$email',
                                `password_hash` = '$pHash',
                                `iframe_token` = '$iframe',
                                `api_access_token` = '$api',
                                `access` = '0'");
                  echo json_encode([
                    "result" => "success",
                    "msg" => "Wait for access confirmation"
                ]);              
    } else {
        echo json_encode([
            "result" => "error",
            "msg" => "Password must be at least 6 characters"
        ]);
    }
}