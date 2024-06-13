<?php
// Garante a autenticação do usuário
include '../DbConnection/auth.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/loan_page.css">
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
            <div class="info-box" id="loan-history">
                <!-- Empréstimos serão carregados aqui via AJAX -->
            </div>
        </div>
        <!-- Botão para gerar novos empréstimos -->
        <button class="generate-loan-button" onclick="window.location.href='loan.php'">Gerar Empréstimo</button>
    </div>

    <div class="continuar">
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        // Função para carregar o histórico de empréstimos via AJAX
        function loadLoanHistory() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '../DBConnection/loan_history.php', true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById('loan-history').innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }
        // Carrega o histórico de empréstimos quando a página é carregada
        window.onload = loadLoanHistory;

        function sacar(loanRequestId) {
            $.ajax({
                type: 'POST',
                url: '../DBConnection/loanrecieve.php',
                data: { loanRequestId: loanRequestId },
                dataType: 'json',
                success: function(response) {
                    alert(response.message); // Exibe uma mensagem de sucesso ou erro
                    // Atualize a interface do usuário conforme necessário após o saque
                    if (response.status === 'success') {
                        // Exemplo: recarregue a lista de empréstimos
                        window.location.reload(); // Atualiza a página após o saque
                    }
                },
                error: function() {
                    alert('Erro ao processar a solicitação.'); // Exibe uma mensagem de erro genérica
                }
            });
        }
    </script>
</body>
</html>