<?php
// Inclui a autenticação do usuário e a conexão com o banco de dados
include '../DbConnection/auth.php';
include '../DbConnection/dbconnection.php';

// Obtém os dados do formulário
$email = $_POST['email'];
$amount = $_POST['amount'];
$cpf = $_POST['cpf'];
$name = $_POST['name'];

// Remove pontos e traços do CPF
$cpf = preg_replace('/[.\-]/', '', $cpf);

// Remove o "R$" e converte a quantia para um número de ponto flutuante
$amount = str_replace(['R$', '.'], '', $amount);
$amount = str_replace(',', '.', $amount);
$amount = floatval(str_replace(['R$', '.', ','], ['', '', '.'], $amount));

// Obtém o ID do usuário logado
// Inicia a sessão se ainda não estiver ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userID = $_SESSION['user_id']; // Supondo que você armazena o ID do usuário na sessão

// Verifica se o email fornecido condiz com o email da conta logada
$query = "SELECT * FROM Users WHERE UserID = ? AND Email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('is', $userID, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Email não corresponde à conta logada.";
    exit;
}

$user = $result->fetch_assoc();

// Verifica se o CPF fornecido condiz com o email
if ($user['CPF'] !== $cpf) {
    echo "CPF não corresponde ao email fornecido.";
    exit;
}

// Verifica se o saldo do usuário é maior que 500
if ($user['Balance'] <= 500) {
    echo "Saldo insuficiente. O saldo deve ser maior que 500.";
    exit;
}

// Verifica se o nome fornecido corresponde ao nome na tabela
$fullName = $user['FirstName'] . ' ' . $user['LastName'];
if ($fullName !== $name) {
    echo "Nome não corresponde ao nome na conta.";
    exit;
}

// Verifica se o usuário tem menos de 5 transações
$query = "SELECT COUNT(*) as transaction_count FROM Transactions WHERE SenderID = ? OR ReceiverID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ii', $userID, $userID);
$stmt->execute();
$result = $stmt->get_result();
$count = $result->fetch_assoc()['transaction_count'];

if ($count < 5) {
    echo "Por favor, movimente mais sua conta bancária.";
    exit;
}

// Verifica se já existe um pedido de empréstimo pendente ou aprovado para o usuário
$query = "SELECT * FROM LoanRequests WHERE UserID = ? AND (RequestStatus = 'Pendente')";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Você já possui um empréstimo pendente";
    exit;
}

// Se todas as validações passarem, prossegue com a solicitação de empréstimo
$query = "INSERT INTO LoanRequests (UserID, Amount, RequestDate, RequestStatus) VALUES (?, ?, NOW(), 'Pendente')";
$stmt = $conn->prepare($query);
$stmt->bind_param('id', $userID, $amount);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Solicitação de empréstimo enviada com sucesso.";
} else {
    echo "Erro ao enviar a solicitação de empréstimo.";
}

$stmt->close();
$conn->close();
?>