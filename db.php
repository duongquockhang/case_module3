<?php
    define('ROOT_URL','http://localhost/module3_new/');
    define('ROOT_DIR', dirname(__FILE__) );

$username   = 'root';
$password   = '';
$database   = 'c05';
try {
    $conn = new PDO('mysql:host=localhost;dbname='.$database, $username, $password);
} catch (Exception $e) {
    // echo $e->getMessage();
    echo '<h1>Khong the ket noi CSDL</h1>';
}