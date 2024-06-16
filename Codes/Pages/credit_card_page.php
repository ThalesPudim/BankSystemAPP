<?php
//Garante a autenticação do usuário
include '../DbConnection/auth.php';


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/code_bar.css">
    <title>Ticket</title>
</head>
<body>
    <header>
        <img id="back-icon" src="../images/Back.png" alt="">
    </header>

    <h1 class="center-text">Your Card</h1>

    <div class="payment-options">
        <div class="credit-card">
            <div class="card-chip"></div>
            <div class="card-number">1234 5678 9012 3456</div>
            <div class="card-name"></strong> <?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?></div>
            <div class="card-expiry">12/24</div>
        </div>
    </div>

    <div class="mais-opcoes">
        <div class="assistente">
        <h3>Credit Card</h3>
        </div>
        <div class="busca-boleto">
        <h3>Month Bill</h3>
        </div>
        <div class="debito-automatico">
        <h3>Automatic Debt</h3>
        </div>
    </div>

    <footer></footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const backIcon = document.getElementById('back-icon');

        backIcon.addEventListener('click', function () {
            // Redireciona para a próxima página após um pequeno atraso
            setTimeout(() => {
                window.location.href = 'home_page.php'; 
            }, 250); 
        });
    });

    </script>
</body>
</html>