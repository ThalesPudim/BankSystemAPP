<?php
// Inclua o arquivo de conexão com o banco de dados
include '../DbConnection/dbconnection.php';
session_start();

// Obtenha o ID do usuário da sessão
$user_id = $_SESSION['user_id'];

// Consulta para obter o saldo atual do usuário
$query = "SELECT Balance FROM Users WHERE UserID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($balance);
$stmt->fetch();
$stmt->close();

// Retorne o saldo como resposta JSON
echo json_encode(['balance' => number_format($balance, 2, ',', '.')]);
?>