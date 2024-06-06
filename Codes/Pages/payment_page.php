<?php
include '../DbConnection/auth.php';
include '../DbConnection/dbconnection.php';

// Obtém o ID do usuário logado
$user_id = $_SESSION['user_id'];

// Consulta para obter as transações do usuário
$sql = "
SELECT 
    Transactions.Amount,
    Transactions.TransactionDate,
    UserTransactions.UserID,
    UserTransactions.TransactionID,
    TransactionType.TypeName AS TransactionType
FROM 
    Transactions
JOIN 
    UserTransactions ON Transactions.TransactionID = UserTransactions.TransactionID
JOIN
    TransactionType ON UserTransactions.TransactionID = TransactionType.TransactionTypeID
WHERE 
    UserTransactions.UserID = '$user_id'
ORDER BY 
    Transactions.TransactionDate DESC
";

$result = $conn->query($sql);

// Fecha a conexão com o banco de dados
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco - Protótipo</title>
    <link rel="stylesheet" type="text/css" href="../Style/payment.css?v=2">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon-container">
                <img src="../images/user_icon.png" alt="User" style="width: 45px; height: 45px; margin-left: 0px; border-radius: 50%; border: 2px solid white;">
            </div>
            <div class="icon-container">
            <img id="back-icon" src="../images/Back.png" alt="Help" style="width: 45px; height: 45px; margin-left: 0px; border-radius: 50%; border: 2px solid white;">
            </div>
        </div>
        
        <div class="BalanceHistory">
            <h2>Históricos de transferencia</h2>
            <div class="history-window">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $amount = $row['Amount'];
                        $transaction_date = $row['TransactionDate'];
                        $transaction_type = $row['TransactionType'];
                        
                        // Define o sinal baseado no tipo de transação
                        $sign = $transaction_type == 'send' ? '-' : '+';

                        echo "<p>$transaction_date - $sign R$ " . number_format($amount, 2, ',', '.') . "</p>";
                    }
                } else {
                    echo "<p>Sem transações registradas.</p>";
                }
                ?>
            </div>
        </div>
        
        <button class="Payment" id="paymentButton">
            Realizar pagamento
        </button>
        
        <div class="PaymentScreen" id="paymentScreen">
            <div class="header">
                <div class="icon-container">
                    <img id="closeButton" src="../images/Back.png" alt="User" style="width: 45px; height: 45px; margin-left: 0px; border-radius: 50%; border: 2px solid white;">
                </div>
            </div>

            <div class="balance">
                <h2>Saldo</h2>
                <div class="balance-container">
                    <input type="checkbox" id="toggle-balance" class="toggle-checkbox">
                    <label for="toggle-balance" class="toggle-label">
                        <span class="eye-icon"><img src="../images/saldo-visivel.png" alt="" style="max-width: 50px;"></span>
                        <span class="eye-icon-hidden"><img src="../images/saldo-nao-visivel.png" alt="" style="max-width: 50px;"></span>
                    </label>
                    <p>R$ <?php echo number_format($_SESSION['balance'], 2, ',', '.'); ?></p>
                </div>
            </div>
            
            <h2 class="info-title">Payment information</h2>
            <div class="payment-form">
                <form id="transferForm" method="post" action="../DBConnection/transfer.php">
                    <div class="input-group">
                        <input type="email" name="email" id="emailInput" placeholder="Email do destinatário" required>
                    </div>
                    <div class="input-group">
                        <input type="number" name="amount" id="amountInput" placeholder="Quantia a transferir" required min="0.01" step="0.01">
                    </div>
                        <button type="submit" id="sendButton" style="background-color: #003366; color: white;">Enviar</button>
                </form>
            </div>


            <div class="loan-requests">
                <h2>Report</h2>
                <div class="carousel-container alert">
                    <h2>Attention:</h2>
                    <p>Por favor, verifique todas as informações antes de confirmar a transferência. Uma vez que o botão de envio seja pressionado, as ações não poderão ser revertidas.</p>
                </div>
            </div>
    
            <div id="paymentLightbox" class="lightbox">
                <div class="lightbox-content">
                    <div id="loadingAnimation" class="loading-animation"></div>
                    <div id="successMessage" class="success-message">
                        <img src="../images/sucess.png" alt="Success" style="width: 50px; height: 50px;">
                        <p>Pagamento realizado com sucesso!</p>
                    </div>
                </div>
            </div>
            <div class="purple-line"></div> 
        </div>
    </div>
    <script src="../Script/PaymentScript.js"></script>
</body>
</html>