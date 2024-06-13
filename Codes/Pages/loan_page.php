<?php
//Garante a autenticação do usuário
include '../DbConnection/auth.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/loan_page.css">
    <style>
        
    </style>
    <title>Loan</title>
</head>
<body>
    <header>
        <div class="icon-container">
            <img id="back-icon" src="../images/Back.png" alt="Help">
        </div>
    </header>
    <!-- Tela para armazenar o histórico de empréstimos -->
    <div class="history-container">
        <!-- Caixa de informação com bordas arredondadas -->

        <div class="loan-container">
            <h2>Histórico de Empréstimos</h2>

        <div class="info-box">
            <div class="loan-entry" style="border-bottom: solid red;">
                

                <div class="confirmacao"></div>
            </div>
            <div class="loan-entry">
                
            </div>
            <div class="loan-entry">
                
            </div>
            <div class="loan-entry">
                
            </div>
            <div class="loan-entry">
                
            </div>
            <div class="loan-entry">
                
            </div>
            <div class="loan-entry">
                
            </div>
            <div class="loan-entry">
                
            </div>
            <div class="loan-entry">
                
            </div>
            <div class="loan-entry">
                
            </div>
            <div class="loan-entry">
                
            </div>
            <div class="loan-entry">
                
            </div>
            
                


        </div>
        <!-- Botão para gerar novos empréstimos -->

        </div>
        <button class="generate-loan-button" onclick="window.location.href='loan.php'">Gerar Empréstimo</button>
    </div>

    <div class="continuar">
    </div>

    <script src="../Script/loan_page.js"></script>
</body>
</html>
