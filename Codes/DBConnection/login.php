<?php
// Inclui o arquivo de conexão
include 'dbconnection.php';

// Inicia a sessão
session_start();

// Recebe dados do formulário
$email = $_POST['email'];
$password = $_POST['password'];

// Query para verificar se o e-mail existe e a senha está correta
$sql = "SELECT * FROM Users WHERE Email='$email' AND UserPassword='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // E-mail e senha corretos, login bem-sucedido
    $user = $result->fetch_assoc();

    // Armazena informações do usuário na sessão
    $_SESSION['user_id'] = $user['UserID'];
    $_SESSION['first_name'] = $user['FirstName'];
    $_SESSION['last_name'] = $user['LastName'];
    $_SESSION['date_of_birth'] = $user['DateOfBirth'];
    $_SESSION['email'] = $user['Email'];
    $_SESSION['cpf'] = $user['CPF'];
    $_SESSION['gender'] = $user['Gender'];
    $_SESSION['balance'] = $user['Balance'];
    $_SESSION['account_type_id'] = $user['AccountTypeID']; // Certifique-se de que esta linha está presente e correta

    echo "success";
} else {
    // E-mail ou senha incorretos
    echo "error";
}

$conn->close();
?>