<?php
include '../DbConnection/auth.php';
include '../DbConnection/dbconnection.php';

// Obtém o ID do usuário logado
$user_id = $_SESSION['user_id'];

// Obtém os dados do formulário
$recipient_email = $_POST['email'];
$amount = floatval($_POST['amount']);

// Verifica se o valor é positivo
if ($amount <= 0) {
    echo "Valor inválido";
    exit;
}

// Inicia uma transação
$conn->begin_transaction();

try {
    // Obtém o saldo atual do usuário
    $stmt = $conn->prepare("SELECT Balance FROM Users WHERE UserID = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($balance);
    $stmt->fetch();
    $stmt->close();

    // Verifica se o usuário possui saldo suficiente
    if ($balance < $amount) {
        throw new Exception("Saldo insuficiente");
    }

    // Obtém os dados do destinatário
    $stmt = $conn->prepare("SELECT UserID, Balance FROM Users WHERE Email = ?");
    $stmt->bind_param("s", $recipient_email);
    $stmt->execute();
    $stmt->bind_result($recipient_id, $recipient_balance);
    $stmt->fetch();
    $stmt->close();

    // Verifica se o destinatário foi encontrado
    if (!$recipient_id) {
        throw new Exception("Destinatário não encontrado");
    }

    // Atualiza o saldo do remetente
    $stmt = $conn->prepare("UPDATE Users SET Balance = Balance - ? WHERE UserID = ?");
    $stmt->bind_param("di", $amount, $user_id);
    $stmt->execute();
    $stmt->close();

    // Atualiza o saldo do destinatário
    $stmt = $conn->prepare("UPDATE Users SET Balance = Balance + ? WHERE UserID = ?");
    $stmt->bind_param("di", $amount, $recipient_id);
    $stmt->execute();
    $stmt->close();

    // Registra a transação
    $stmt = $conn->prepare("INSERT INTO Transactions (Amount, TransactionDate) VALUES (?, NOW())");
    $stmt->bind_param("d", $amount);
    $stmt->execute();
    $transaction_id = $stmt->insert_id;
    $stmt->close();

    // Associa a transação ao remetente
    $stmt = $conn->prepare("INSERT INTO UserTransactions (UserID, TransactionID) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $transaction_id);
    $stmt->execute();
    $stmt->close();

    // Associa a transação ao destinatário
    $stmt = $conn->prepare("INSERT INTO UserTransactions (UserID, TransactionID) VALUES (?, ?)");
    $stmt->bind_param("ii", $recipient_id, $transaction_id);
    $stmt->execute();
    $stmt->close();

    // Define o tipo de transação para o remetente e destinatário
    $stmt = $conn->prepare("INSERT INTO TransactionType (TransactionTypeID, TypeName) VALUES (?, ?) ON DUPLICATE KEY UPDATE TypeName = VALUES(TypeName)");
    $send_type = 'send';
    $receive_type = 'receive';
    $stmt->bind_param("is", $transaction_id, $send_type);
    $stmt->execute();
    $stmt->bind_param("is", $transaction_id, $receive_type);
    $stmt->execute();
    $stmt->close();

    // Confirma a transação
    $conn->commit();

    echo "Pagamento realizado com sucesso!";
} catch (Exception $e) {
    // Reverte a transação em caso de erro
    $conn->rollback();
    echo "Erro: " . $e->getMessage();
}

// Fecha a conexão com o banco de dados
$conn->close();
?>