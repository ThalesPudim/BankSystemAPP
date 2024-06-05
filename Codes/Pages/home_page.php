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
    <link rel="stylesheet" type="text/css" href="../Style/style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon-container">
                <img src="../images/Sample_User_Icon.png" alt="User" style="width: 45px; height: 45px; margin-left: 0px; border-radius: 50%; border: 2px solid black;">
            </div>
            <div class="icon-container">
            <img src="../images/QuestionMark.png" alt="Help" style="width: 45px; height: 45px; margin-left: 0px; border-radius: 50%; border: 2px solid black;">
            </div>
        </div>
        <div class="balance">
            <h2>Saldo</h2>
            <p style="color: black; font-weight: bold;">R$: <?php echo number_format($_SESSION['balance'], 2, ',', '.'); ?></p>
        </div>
        <div class="menu-wrapper">
            <div class="menu" id="menu">
                <div>
                    <img id="payment-icon" src="../images/money-icon.png" alt="Payment" >
                    <p>Management</p>
                </div>
                <div>
                    <img id="codebar-icon" src="../images/code-bar.png" alt="CodeBar" style="width: 45px; height: 45px; margin-left: 0px; border-radius: 50%; border: 2px solid black;">
                    <p>Ticket</p>
                </div>
                <div>
                    <img id="creditcard-icon" src="../images/credit-card.png" alt="CreditCard" style="width: 45px; height: 45px; margin-left: 0px; border-radius: 50%; border: 2px solid black;">
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
        <img src="../images/Sample_User_Icon.png" alt="User">
        <img src="../images/Logout.png" alt="Logout" id="logoutButton">
        <h2>Informações do Perfil</h2>
        <p><strong>Nome:</strong> <?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?></p>
        <p><strong>Data de Nascimento:</strong> <?php echo date('d/m/Y', strtotime($_SESSION['date_of_birth'])); ?></p>
        <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?></p>
        <p><strong>Tipo de Conta:</strong> <?php echo $account_type; ?></p>
    </div>

    <!-- Painel lateral para exibir informações de ajuda -->
    <div class="help-panel" id="helpPanel">
        <img src="../images/QuestionMark.png" alt="Help">
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