<?php
header('Content-Type: text/html; charset=utf-8');
include 'Context.php';

$dbContext = new Context();

$dbContext->handleRequest('note', 'handleRequest');
