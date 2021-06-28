<?php 
    include $_SERVER['DOCUMENT_ROOT']."/var/autoload.php";
    unset($_SESSION['user']);
    header('Location: /');
?>