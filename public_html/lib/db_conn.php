<?php
header('Content-Type: text/html; charset=utf-8');

$host_name = 'localhost';
$db_id = 'bstest';
$db_pw = 'bs005518!';
$db_name = 'bstest';
$conn = mysqli_connect($host_name, $db_id, $db_pw, $db_name);
if(!$conn){
    die('Connect Error: ' . mysqli_connect_errno());
}
