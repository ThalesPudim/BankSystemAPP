<?php
// Conexão com o banco de dados
$servername = "localhost"; 
$username = "root";
$password = "";
$dbname = "HringBank"; 

// Cria conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

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