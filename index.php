<meta charset="UTF-8">
<?php
header('Content-Type: text/html; charset=utf-8');
include 'Models/Context.php';

$dbContext = new Context();

$dbContext->handleRequest('note', 'handleRequest');
//$query = "SELECT * FROM a";
//
//$statement = $pdo->query($query);
//$stuff = $statement->fetchALL(PDO::FETCH_ASSOC);
//
//$stuff = json_encode($stuff);
