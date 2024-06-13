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

// Remove o "R$" e formata a quantia para um número inteiro
$amount = str_replace(['R$',','], ['', '', ''], $amount);
$amount = floatval(str_replace(',', '.', $amount)); 

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
    $response = array(
        'status' => 'error',
        'message' => 'Email não corresponde à conta logada.'
    );
    echo json_encode($response);
    exit;
}

$user = $result->fetch_assoc();

// Verifica se o CPF fornecido condiz com o email
if ($user['CPF'] !== $cpf) {
    $response = array(
        'status' => 'error',
        'message' => 'CPF não corresponde ao email fornecido.'
    );
    echo json_encode($response);
    exit;
}

// Verifica se o saldo do usuário é maior que 500
if ($user['Balance'] <= 500) {
    $response = array(
        'status' => 'error',
        'message' => 'Saldo insuficiente. O saldo deve ser maior que 500.'
    );
    echo json_encode($response);
    exit;
}

// Verifica se o nome fornecido corresponde ao nome na tabela
$fullName = $user['FirstName'] . ' ' . $user['LastName'];
if ($fullName !== $name) {
    $response = array(
        'status' => 'error',
        'message' => 'Nome não corresponde ao nome na conta.'
    );
    echo json_encode($response);
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
    $response = array(
        'status' => 'error',
        'message' => 'Por favor, movimente mais sua conta bancária.'
    );
    echo json_encode($response);
    exit;
}

// Verifica se já existe um pedido de empréstimo pendente ou aprovado para o usuário
$query = "SELECT * FROM LoanRequests WHERE UserID = ? AND (RequestStatus = 'Pendente')";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $response = array(
        'status' => 'error',
        'message' => 'Você já possui um empréstimo pendente ou aprovado.'
    );
    echo json_encode($response);
    exit;
}

// Se todas as validações passarem, prossegue com a solicitação de empréstimo
$query = "INSERT INTO LoanRequests (UserID, Amount, RequestDate, RequestStatus, WithdrawAvailable) VALUES (?, ?, NOW(), 'Pendente', FALSE)";
$stmt = $conn->prepare($query);
$stmt->bind_param('id', $userID, $amount);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $response = array(
        'status' => 'success',
        'message' => 'Solicitação de empréstimo enviada com sucesso.'
    );
    echo json_encode($response);
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Erro ao enviar a solicitação de empréstimo.'
    );
    echo json_encode($response);
}

$stmt->close();
$conn->close();
?>