<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=ijdb;charset=utf8mb4', 'ijdbuser', 'abc123!');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'UPDATE joke SET jokedate="2018-04-20"
        WHERE joketext LIKE "%chicken%"';
    $pdo->exec($sql);
} catch (PDOException $e) {
    $output = 'Unable to add new joke! ' . $e->getMessage();
    include 'output.html.php';
    exit();
}

$output = 'Successfully added joke!';
include 'output.html.php';
