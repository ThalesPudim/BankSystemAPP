<?php
//Garante a autenticação do usuário
include '../DbConnection/auth.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco - Protótipo</title>
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
                        $('#balance').text('R$ ' + response.balance);
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
    <link rel="stylesheet" type="text/css" href="../Style/style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon-container">
                <img src="../images/user_icon.png" alt="User" style="width: 45px; height: 45px; margin-left: 0px; border-radius: 50%; border: 2px solid white;">
            </div>
            <div class="icon-container">
            <img src="../images/QuestionMark.png" alt="Help" style="width: 45px; height: 45px; margin-left: 0px; border-radius: 50%; border: 2px solid;">
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
                <p class="balance fadeInLeft" id="balance"></p>
            </div>
        </div>
        <div class="menu-wrapper">
            <div class="menu" id="menu">
                <div>
                <img class="payment-icon"  id="payment-icon" src="../images/money-icon.png" alt="Payment" >
                    <p>Management</p>
                </div>
                <div>
                <img class="code-bar"  id="codebar-icon" src="../images/code-bar.png" alt="CodeBar">
                    <p>Ticket</p>
                </div>
                <div>
                    <img id="creditcard-icon" src="../images/credit-card.png" alt="CreditCard" style="width: 45px; height: 45px; margin-left: 0px;">
                    <p>My Cards</p>
                </div>
                <!-- Adicione mais item para deixar bonito -->
            </div>
        </div>
        
        <div class="loan-requests">
            <h2>Loan Requests ></h2>
            <h4 class="underlined">Information, suggestions, verification</h4>
        </div>

        <div class="news">
            <h2>News</h2>
            <div class="carousel-container"> <!-- carrossel está aqui -->
                <div class="carousel">
                    <div class="carousel-item">
                        <img src="../images/Working-Woman.png" alt="news">
                    </div>
                    <div class="carousel-item">
                        <img src="../images/people-working.jpg" alt="news">
                    </div>
                </div>
                <button class="carousel-control prev">⟨</button>
                <button class="carousel-control next">⟩</button>
            </div>
        </div>
    </div>
    <div class="purple-line"></div> <!-- Linha Roxa no final da pagina-->
    <div class="profile-panel" id="profilePanel">
        <!-- Conteúdo do painel lateral (informações do perfil) -->
        <div class="icone-paineis">
            <img src="../images/user_icon.png" alt="User">
        </div>
        <h2>Informações do Perfil</h2>
        <p><strong>Nome:</strong> <?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?></p>
        <p><strong>Data de Nascimento:</strong> <?php echo date('d/m/Y', strtotime($_SESSION['date_of_birth'])); ?></p>
        <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?></p>
        <p><strong>Tipo de Conta:</strong> <?php echo $account_type; ?></p>
        <div class="botao-sair" id="logoutButton">
            <h2>Sair do aplicativo</h2><img src="../images/Logout.png" alt="">
        </div>
    </div>

    <!-- Painel lateral para exibir informações de ajuda -->
    <div class="help-panel" id="helpPanel">
        <div class="icone-paineis">
            <img src="../images/QuestionMark.png" alt="Help">
        </div>
        <h2>Ajuda</h2>
        <p>Sei la informação</p>
        <p>Para suporte, entre em contato conosco.</p>
    </div>

    <div id="logoutLightbox" class="lightbox">
    <div class="lightbox-content">
        <h2>Deseja realmente deslogar?</h2>
        <div class="button-container">
            <button id="confirmLogoutButton" type="button">Sim</button>
            <button id="cancelButton" type="button">Cancelar</button>
        </div>
    </div>
</div>
    <!-- Referenciando Script-->
    <script src="../Script/Script.js"></script>
</body>
</html>