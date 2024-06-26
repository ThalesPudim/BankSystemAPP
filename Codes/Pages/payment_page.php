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
    Transactions.SenderID,
    Transactions.ReceiverID,
    'send' AS TransactionType,
    Receiver.Email AS Email
FROM 
    Transactions
JOIN 
    Users AS Receiver ON Transactions.ReceiverID = Receiver.UserID
WHERE 
    Transactions.SenderID = '$user_id'

UNION

SELECT 
    Transactions.Amount,
    Transactions.TransactionDate,
    Transactions.SenderID,
    Transactions.ReceiverID,
    'receive' AS TransactionType,
    Sender.Email AS Email
FROM 
    Transactions
JOIN 
    Users AS Sender ON Transactions.SenderID = Sender.UserID
WHERE 
    Transactions.ReceiverID = '$user_id'
ORDER BY 
    TransactionDate DESC
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        function updateBalance() { 
            $.ajax({
                url: '../DBConnection/get_balance.php',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.balance !== undefined) {
                        $('#balance').text('R$: ' + response.balance);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erro ao buscar o saldo:', error);
                }
            });
        }

        // Atualiza o saldo a cada 5 segundos
        setInterval(updateBalance, 5000);
        
        // Atualiza o saldo ao carregar a página
        updateBalance();
    });
    </script>
    <title>Banco - Protótipo</title>
    <link rel="stylesheet" type="text/css" href="../Style/payment.css?v=2">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon-container">
            <img id="back-icon" src="../images/Back.png" alt="Help" style="width: 45px; height: 45px; margin-left: 0px; border-radius: 50%; border: 2px solid white;">
            </div>
        </div>
        
        <div class="BalanceHistory">
            <h2>Transfer Histories</h2>
            <div class="history-window">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $amount = $row['Amount'];
                        $transaction_date = $row['TransactionDate'];
                        $transaction_type = $row['TransactionType'];
                        $email = $row['Email'];
                
                        // Define o sinal baseado no tipo de transação
                        $sign = $transaction_type == 'send' ? '-' : '+';
                        $class = $sign == '-' ? "Send" : "Receive";  //Explicar essa parada pro Roviero
                        
                        $color = $class == 'Send' ? "color: red;" : "color: green;"; // Ajustado para estilo CSS válido

                    echo "<p class='$class' style='color: black';>$transaction_date : ". "<span style='$color' > $sign R$ " . number_format($amount, 2, ',', '.') ."</span>" ." - $email</p>";

                    }
                } else {
                    echo "<p>Sem transações registradas.</p>";
                }
                ?>
            </div>
        </div>
        
        <button class="Payment" id="paymentButton">
            Make a Transfer
        </button>
        
        <div class="PaymentScreen" id="paymentScreen">
            <div class="header">
                <div class="icon-container">
                    <img id="closeButton" src="../images/Arrow-down.png" alt="User" style="width: 45px; height: 45px; margin-left: 0px; border-radius: 50%; border: 2px solid white;">
                </div>
            </div>

            <div class="balance" style="background-color: #f9f9f9;">
                <h2>Balance</h2>
                <div class="balance-container">
                    <p id="balance">R$ <?php echo number_format($_SESSION['balance'], 2, ',', '.'); ?></p>
                </div>
            </div>
            
            <div class="Payment-information">
                <h2 class="info-title">Payment information</h2>
                <div class="payment-form">
                    <form id="transferForm" method="post" action="../DBConnection/transfer.php">
                        <div class="input-group">
                            <input type="email" name="email" id="emailInput" placeholder="Recipient's Email Addres" required>
                        </div>
                        <div class="input-group">
                            <input type="number" name="amount" id="amountInput" placeholder="Amount to Transfer" required min="0.01" step="0.01">
                        </div>
                            <button type="submit" id="sendButton" style="background-color: #003366; color: white;">Sent</button>
                    </form>
                </div>
            </div>

            <div class="loan-requests">
                <h2>Report</h2>
                <div class="carousel-container alert">
                    <h2>Attention:</h2>
                    <p>Please check all information before confirming the transfer. Once the submit button is pressed, actions cannot be reversed.</p>
                </div>
            </div>
    
            <div id="paymentLightbox" class="lightbox">
                <div class="lightbox-content">
                    <div id="loadingAnimation" class="loading-animation"></div>
                    <div id="successMessage" class="success-message">
                        <img src="../images/sucess.png" alt="Success" style="width: 50px; height: 50px;">
                        <p>Payment made successfully!</p>
                    </div>
                    <div id="errorMessage" class="error-message">
                        <img src="../images/failure.png" alt="Error" style="width: 50px; height: 50px;">
                        <p>Error making payment.</p>
                    </div>
                </div>
            </div>
                
            <div class="purple-line"></div> 
        </div>
    </div>
    <script src="../Script/PaymentScript.js"></script>
</body>
</html>