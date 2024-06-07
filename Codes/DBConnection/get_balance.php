<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['balance'])) {
    echo json_encode(['balance' => number_format($_SESSION['balance'], 2, ',', '.')]);
} else {
    echo json_encode(['balance' => '0,00']);
}
?>