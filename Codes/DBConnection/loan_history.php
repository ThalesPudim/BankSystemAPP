<?php
// Garante a autenticação do usuário
include '../DbConnection/auth.php';

// Inclui a conexão com o banco de dados
include '../DbConnection/dbconnection.php';

// Pega o ID do usuário logado
$user_id = $_SESSION['user_id'];

// Busca os empréstimos do usuário logado
$sql = "SELECT * FROM LoanRequests WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Gera o HTML para cada empréstimo
$loans_html = '';
while ($row = $result->fetch_assoc()) {
    $status = $row['RequestStatus'];
    $status_color = '';

    if ($status == 'Aprovado') {
        $status_color = 'green';
    } elseif ($status == 'Negado') {
        $status_color = 'red';
    } else {
        $status_color = 'orange';
    }

    // Formata o valor para o formato brasileiro
    $formatted_amount = 'R$ ' . number_format($row['Amount'], 2, ',', '.');

    // Verifica se o saque está disponível
    $withdraw_available = $row['WithdrawAvailable'];

    // Botão para saque
    $withdraw_button = '';
    if ($status == 'Aprovado' && $withdraw_available == 1) {
        $withdraw_button = '<button onclick="sacar(' . $row['LoanRequestID'] . ')">Withdraw</button>';
    } elseif ($status == 'Aprovado' && $withdraw_available == 0) {
        $withdraw_button = '<button disabled>Withdrawal made</button>';
    }

    $newStatus = '';
    if ($row['RequestStatus'] == 'Aprovado'){
        $newStatus = 'Approved';
    } elseif ($row['RequestStatus'] == 'Negado') {
        $newStatus = 'Refused';
    } elseif ($row['RequestStatus'] == 'Pendente') {
        $newStatus = 'Pending';
    } 

    // Constrói o HTML para cada entrada de empréstimo
    $loans_html .= '
    <div class="loan-entry" style="border-bottom: solid ' . $status_color . ';">
        <p>Protocol number: ' . $row['LoanRequestID'] . '</p>
        <p>Amount: ' . $formatted_amount . '</p>
        <p>Request Date: ' . $row['RequestDate'] . '</p>
        <p>Status: ' . $newStatus . '</p>
        <div class="button-animation">
            ' . $withdraw_button . '
        </div>
    </div>';
}

$stmt->close();
$conn->close();

// Retorna o HTML gerado
echo $loans_html;
?>