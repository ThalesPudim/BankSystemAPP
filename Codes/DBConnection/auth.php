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
$sql = "SELECT Type FROM AccountTypes WHERE AccountTypeID='$account_type_id'";
$result = $conn->query($sql);
$account_type = '';
if ($result->num_rows > 0) {
    $account_type_row = $result->fetch_assoc();
    $account_type = $account_type_row['Type'];  // Certifique-se de que o nome da coluna está correto
}

$conn->close();
?>