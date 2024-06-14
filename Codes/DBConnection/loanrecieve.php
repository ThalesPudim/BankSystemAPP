<?php
// Inclui a autenticação do usuário e a conexão com o banco de dados
include '../DbConnection/auth.php';
include '../DbConnection/dbconnection.php';

// Função para sacar o empréstimo
function sacar($loanRequestId, $userId, $conn) {
    // Verifica se o empréstimo está disponível para saque
    $query = "SELECT * FROM LoanRequests WHERE LoanRequestID = ? AND UserID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $loanRequestId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['RequestStatus'] === 'Aprovado' && $row['WithdrawAvailable'] == 1) {
            // Atualiza o saldo do usuário
            $amount = $row['Amount'];
            $update_query = "UPDATE Users SET Balance = Balance + ? WHERE UserID = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param('di', $amount, $userId);
            $update_stmt->execute();

            // Atualiza o status de saque do empréstimo
            $update_loan_query = "UPDATE LoanRequests SET WithdrawAvailable = 0 WHERE LoanRequestID = ?";
            $update_loan_stmt = $conn->prepare($update_loan_query);
            $update_loan_stmt->bind_param('i', $loanRequestId);
            $update_loan_stmt->execute();

            // Retorna verdadeiro se tudo foi atualizado com sucesso
            return true;
        }
    }

    // Retorna falso se não for possível sacar o empréstimo
    return false;
}

// Verifica se foi uma requisição POST para sacar o empréstimo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém o ID do empréstimo e do usuário logado
    $loanRequestId = $_POST['loanRequestId'];
    $userId = $_SESSION['user_id'];

    // Chama a função para sacar o empréstimo
    $sacar = sacar($loanRequestId, $userId, $conn);

    if ($sacar) {
        // Retorna uma resposta JSON de sucesso se o saque foi realizado com sucesso
        $response = array(
            'status' => 'success',
            'message' => 'Withdrawal made successfully.'
        );
        echo json_encode($response);
    } else {
        // Retorna uma resposta JSON de erro se não foi possível sacar o empréstimo
        $response = array(
            'status' => 'error',
            'message' => 'The loan could not be withdrawn.'
        );
        echo json_encode($response);
    }

    exit; // Termina o script após o retorno JSON
}
?>