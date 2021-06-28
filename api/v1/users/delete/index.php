<?php 


include $_SERVER['DOCUMENT_ROOT']."/var/autoload.php";

if ($_SESSION['user']) {
    $userEmail = $_SESSION['user'];
    $userTypeId = $db->query("SELECT * FROM `users` WHERE `email` = '$userEmail'")->fetch_assoc()['user_type_id'];
    $userType = $db->query("SELECT * FROM `user_types` WHERE `id` = '$userTypeId'")->fetch_assoc()['name'];
    
    if ($userType == 'admin') {
        $id = $_POST['id'];
        if ($id) {
            $db->query("DELETE * FROM `users` WHERE `id` = '$id'");
        }
    }
}