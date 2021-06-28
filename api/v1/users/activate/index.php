<?php 


include $_SERVER['DOCUMENT_ROOT']."/var/autoload.php";

if ($_SESSION['user']) {
    $userEmail = $_SESSION['user'];
    $userTypeId = $db->query("SELECT * FROM `users` WHERE `email` = '$userEmail'")->fetch_assoc()['user_type_id'];
    $userType = $db->query("SELECT * FROM `user_types` WHERE `id` = '$userTypeId'")->fetch_assoc()['name'];
    
    if ($userType == 'admin') {
        $id = $_POST['id'];
        if ($id) {
            $db->query("UPDATE `users` SET `access` = 1 WHERE `id` = '$id'");
            mail($userEmail, "Your account has been activated!", "
                <h1>Hello!</h1>
                <p>Your account has been activated.</p>
                <br>
                Now you can login in
            ");
        } 
    }
}