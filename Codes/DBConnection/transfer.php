<?php
include '../DbConnection/auth.php';
include '../DbConnection/dbconnection.php';

$user_id = $_SESSION['user_id'];
$recipient_email = $_POST['email'];
$amount = floatval($_POST['amount']);

$response = array();

if ($amount <= 0) {
    $response['status'] = 'error';
    $response['message'] = 'Invalid Value';
    echo json_encode($response);
    exit;
}

$conn->begin_transaction();

try {
    $stmt = $conn->prepare("SELECT Balance, Email FROM Users WHERE UserID = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($balance, $user_email);
    $stmt->fetch();
    $stmt->close();

    if ($balance < $amount) {
        throw new Exception("Insufficient Funds");
    }

    if ($user_email === $recipient_email) {
        throw new Exception("You cannot send money to yourself.");
    }

    $stmt = $conn->prepare("SELECT UserID, Balance FROM Users WHERE Email = ?");
    $stmt->bind_param("s", $recipient_email);
    $stmt->execute();
    $stmt->bind_result($recipient_id, $recipient_balance);
    $stmt->fetch();
    $stmt->close();

    if (!$recipient_id) {
        throw new Exception("Recipient not found.");
    }

    $stmt = $conn->prepare("UPDATE Users SET Balance = Balance - ? WHERE UserID = ?");
    $stmt->bind_param("di", $amount, $user_id);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("UPDATE Users SET Balance = Balance + ? WHERE UserID = ?");
    $stmt->bind_param("di", $amount, $recipient_id);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO Transactions (Amount, TransactionDate, SenderID, ReceiverID) VALUES (?, NOW(), ?, ?)");
    $stmt->bind_param("dii", $amount, $user_id, $recipient_id);
    $stmt->execute();
    $transaction_id = $stmt->insert_id;
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO UserTransactions (UserID, TransactionID) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $transaction_id);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO UserTransactions (UserID, TransactionID) VALUES (?, ?)");
    $stmt->bind_param("ii", $recipient_id, $transaction_id);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO TransactionType (TransactionTypeID, TypeName) VALUES (?, 'send') ON DUPLICATE KEY UPDATE TypeName = 'send'");
    $stmt->bind_param("i", $transaction_id);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO TransactionType (TransactionTypeID, TypeName) VALUES (?, 'receive') ON DUPLICATE KEY UPDATE TypeName = 'receive'");
    $stmt->bind_param("i", $transaction_id);
    $stmt->execute();
    $stmt->close();

    $conn->commit();

    $_SESSION['balance'] = $balance - $amount;

    $response['status'] = 'success';
    $response['message'] = 'Payment made successfully!';
    echo json_encode($response);
} catch (Exception $e) {
    $conn->rollback();
    $response['status'] = 'error';
    $response['message'] = 'Erro: ' . $e->getMessage();
    echo json_encode($response);
}

$conn->close();
?>