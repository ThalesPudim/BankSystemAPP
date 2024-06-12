<?php
//Garante a autenticação do usuário
include '../DbConnection/auth.php';

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/loan.css">
    <title>Loan</title>
</head>
<body>
    <header>
        <div class="icon-container">
            <img id="back-icon" src="../images/Back.png" alt="Help">
        </div>

    </header>

    <div class="titulo">
        <h2>You will use your Loan for?</h2>
    </div>

    <div class="opcoes">
        <div class="objetivos" id="opcao1">
            <img src="../images/bills.png" alt="">
            <h3>Bills</h3>
        </div>
        <div class="objetivos" id="opcao2">
            <img src="../images/repair.png" alt="">
            <h3>Repairs and Renovations</h3>
        </div>
        <div class="objetivos" id="opcao3">
            <img src="../images/business.png" alt="">
            <h3>Invest in my business</h3>
        </div>
        <div class="objetivos" id="opcao4">
            <img src="../images/travel.png" alt="">
            <h3>Travel</h3>
        </div>
        <div class="objetivos" id="opcao5">
            <img src="../images/debts.png" alt="">
            <h3>Debts</h3>
        </div>
        <div class="objetivos" id="opcao6">
            <img src="../images/medical.png" alt="">
            <h3>Medical Services</h3>
        </div>
        <div class="objetivos" id="opcao7">
            <img src="../images/others.png" alt="">
            <h3>Other</h3>
        </div>
    </div>

    <div class="continuar">
        <img id ="continue-icon" src="../images/continue.png" alt="" style="width: 45px; height: 45px; margin-left: 0px; border-radius: 50%; border: 2px solid white;"></button>
    </div>

    <script src="../Script/Loan.js">
    </script>
</body>
</html>