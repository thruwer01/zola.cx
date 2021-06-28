<?php 

function generateToken () {
    return $token = bin2hex(random_bytes(16));
}