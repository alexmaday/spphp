<?php
try {
    // open the db
    $options = array();
    $pdo = new PDO('mysql:host=localhost;dbname=ijdb;charset=utf8mb4', 'ijdbuser', 'abc123!', array(
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ));
} catch (PDOExecption $e) {
    $output = 'Unable to connect to database server. ' . $e->getMessage();
    include 'error.html.php';
    exit();
}
try {

    $sql = 'SELECT joketext FROM joke';
    $result = $pdo->query($sql);
} catch (PDOException $e) {
    $output = 'Error fetching jokes. ' . $e->getMessage();
    include 'error.html.php';
    exit();
}
while ($row = $result->fetch()) {
    $jokes[] = $row['joketext'];
}
include 'jokes.html.php';
