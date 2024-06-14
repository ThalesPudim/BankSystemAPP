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

    <h1 class="center-text">Payment Options</h1>

    <div class="payment-options">
        <div class="fatura-cartao">
        <img src="../images/card.png" alt="">
        <p>Credit Card Bill</p>
        </div>
        <div class="boleto">
        <img src="../images/code-bar-white.png" alt="">
        <p>Ticket</p>
        </div>
        <div class="pix">
        <img src="../images/money-icon-white.png" alt="">
        <p>Pix</p>
        </div>
    </div>

    <div class="mais-opcoes">
        <div class="assistente">
        <h3>Payment Assistent</h3>
        </div>
        <div class="busca-boleto">
        <h3>Ticket Finder</h3>
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