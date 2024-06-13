<?php
// Garante a autenticação do usuário
include '../DbConnection/auth.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/loan_simulation.css">
    <title>Loan Simulation</title>

</head>
<body>
    <header>
        <div class="icon-container">
            <img id="back-icon" src="../images/Back.png" alt="Back">
        </div>
    </header>
    <div class="opcoes">
        <div id="Objetivo" class="objetivos">
            <!-- O conteúdo selecionado na pagina anterior será inserido aqui, não mexer -->
    </div>
    <div id="form-container">
        <form action="../DBConnection/loanverification.php" method="post" class="dados">
            <div class="input-group">
                <input type="email" name="email" id="emailInput" placeholder="E-mail" required>
            </div>
            <div class="input-group">
                <input type="text" name="amount" id="amountInput" placeholder="Quantia a transferir (R$ 00,00)" required onkeypress="return onlyNumbersAndDots(event)" oninput="formatCurrency(this)">
            </div>
            <div class="input-group">
                <input type="text" name="cpf" id="cpfInput" placeholder="CPF (Apenas números)" required maxlength="14" oninput="formatarCPF(this)">
            </div>
            <div class="input-group">
                <input type="text" name="name" id="nameInput" placeholder="Nome Completo" required>
            </div>
        </form>

        <button type="submit" id="sendButton" class="enviar">Enviar</button>

    </div>
    <div class="continuar">
    </div>
    <script src="../Script/LoanSimulation.js"></script>
</body>
</html>