<?php
function get_pdo()
{
    $host = 'localhost';
    $dbname = 'myblog';
    $username = 'root';
    $password = '';
    $port = '3308';
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;port=$port;charset=utf8mb4",$username,$password);
    return $pdo;
}
?>