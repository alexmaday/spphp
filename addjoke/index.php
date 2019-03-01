<?php
$dsn = "mysql:host=localhost;dbname=ijdb";
$user = "ijdbuser";
$pw = "abc123!";

$sql = 'INSERT INTO "joke"'
try {
    $pdo = new PDO($dsn, $user, $pw, "utf8mb4");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec($sql);   
} catch (PDOException $e) {
    // deal with error
    $output = 'Database failure! ' . $e->getMessage();
    include 'output.html.php';
    exit();
}

$output = 'Added joke sucessfully';
include 'output.html.php';