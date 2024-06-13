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
    <style>
        .icon-container {
            display: flex;
            justify-content: flex-start;
            padding: 10px;
        }

        #back-icon {
            cursor: pointer;
        }

        .history-container {
            padding: 20px;
            background-color: #f9f9f9;
            min-height: calc(100vh - 150px); /* Ajusta a altura conforme necessário */
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .info-box {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            width: 80%;
            max-width: 600px;
            height: 80%;
            max-height: 600px;
            margin-bottom: 20px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .info-box h2 {
            margin-top: 0;
        }

        .loan-entry {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            width: 100%;
            margin-bottom: 10px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .loan-entry p {
            margin: 5px 0;
        }

        .generate-loan-button {
            background-color: #4CAF50;
            color: white;
            padding: 15px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .generate-loan-button:hover {
            background-color: #45a049;
        }

        .continuar {
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
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
        <div class="info-box">
            <h2>Histórico de Empréstimos</h2>
            <!-- Exemplo de conteúdo do histórico -->
            <div class="loan-entry">
                <p>Empréstimo #1</p>
                <p>Data: 12/06/2023</p>
                <p>Valor: R$ 1000,00</p>
            </div>
            <div class="loan-entry">
                <p>Empréstimo #2</p>
                <p>Data: 01/05/2023</p>
                <p>Valor: R$ 2000,00</p>
            </div>
            <!-- Adicione mais entradas conforme necessário -->
        </div>
        <!-- Botão para gerar novos empréstimos -->
        <button class="generate-loan-button" onclick="window.location.href='generate_loan_page.html'">Gerar Empréstimo</button>
    </div>

    <div class="continuar">
    </div>

    <script src="../Script/loan_page.js"></script>
</body>
</html>
