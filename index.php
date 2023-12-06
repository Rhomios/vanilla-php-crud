<?php
header('Content-Type: text/html; charset=utf-8');
include 'scr/Context.php';

$dbContext = new Context();

echo $_ENV['POSTGRES_DB'];

$dbContext->handleRequest('note', 'handleRequest');
