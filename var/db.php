<?php

$config = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/var/config.json'));

//bd
$db = new mysqli(
    $config->mysql->db_host,
    $config->mysql->db_user,
    $config->mysql->db_password,
    $config->mysql->db_name
);

$db->set_charset('utf8');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}