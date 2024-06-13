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

    $formatted_amount = 'R$ ' . number_format($row['Amount'], 2, ',', '.');

    $loans_html .= '
    <div class="loan-entry" style="border-bottom: solid ' . $status_color . ';">
        <p>Empréstimo ID: ' . $row['LoanRequestID'] . '</p>
        <p>Quantia: ' . $formatted_amount . '</p>
        <p>Data do Pedido: ' . $row['RequestDate'] . '</p>
        <p>Status: ' . $row['RequestStatus'] . '</p>
    </div>';
}

$stmt->close();
$conn->close();

// Retorna o HTML gerado
echo $loans_html;
?>