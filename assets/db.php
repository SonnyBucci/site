<?php
$host = 'localhost';
$base   = 'ADI_BETA';
$user = 'root';
$pass = 'Buford5405!';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$base;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$db = new PDO($dsn, $user, $pass, $opt);
?>