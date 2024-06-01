<?php
// Inclui o arquivo de conexão
include 'dbconnection.php';

// Recebe dados do formulário
$email = $_POST['email'];
$password = $_POST['password'];

// Query para verificar se o e-mail existe e a senha está correta
$sql = "SELECT * FROM Users WHERE Email='$email' AND UserPassword='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // E-mail e senha corretos, login bem-sucedido
    echo "success";
} else {
    // E-mail ou senha incorretos
    echo "error";
}

$conn->close();
?>