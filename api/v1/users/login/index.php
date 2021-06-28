<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/var/autoload.php';
header('Content-type: application/json');
$email = $_GET['email'];
$password = $_GET['password'];

$res = $db->query("SELECT * FROM `users` WHERE `email` = '$email' LIMIT 1");

if ($res->num_rows == 1) {
    $user = $res->fetch_assoc();
    $pHash = $user['password_hash'];
    $timeBlock = $user['time_block'];
    $timeNow = time();
    if ($timeBlock) {
        if ($timeNow < $timeBlock) {
            echo json_encode([
                "result" => "error",
                "msg" => "You are block by administrator!"
            ]);
        }
    } else {
        if (password_verify($password, $pHash)) {
            if ($user['access']) {
                echo json_encode([
                    "result" => "success",
                    "msg" => "You are login successfully"
                ]);
                $_SESSION['user'] = $user['email'];
            } else {
                echo json_encode([
                    "result" => "error",
                    "msg" => "You are not have access"
                ]);
            }
        } else {
            echo json_encode([
                "result" => "error",
                "msg" => "Wrong password! Try again"
            ]);
        }
    }
} else {
    echo json_encode([
        "result" => "error",
        "msg" => "User with email $email not found! Try again"
    ]);
}