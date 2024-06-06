<?php
// Inicia a sessão
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    // Redireciona para a página de login se não estiver logado
    header("Location: login_page.html");
    exit();
}

// Verifica se a variável de sessão account_type_id está definida
if (!isset($_SESSION['account_type_id'])) {
    echo "Erro: Tipo de conta não definido.";
    exit();
}

// Conecta ao banco de dados
include 'dbconnection.php';

// Obtém o tipo de conta do usuário logado
$account_type_id = $_SESSION['account_type_id'];

// Usa prepared statements para evitar SQL injection
$sql = "SELECT Type FROM AccountTypes WHERE AccountTypeID = ?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("i", $account_type_id);
    $stmt->execute();
    $stmt->bind_result($account_type);
    $stmt->fetch();
    $stmt->close();

    // Verifica se o tipo de conta foi encontrado
    if (!$account_type) {
        echo "Erro: Tipo de conta não encontrado.";
        exit();
    }
} else {
    echo "Erro: Falha na preparação da consulta.";
    exit();
}

$conn->close();
?>