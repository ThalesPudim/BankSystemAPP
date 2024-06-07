function togglePaymentScreen() {
    var paymentScreen = document.getElementById('paymentScreen');
    if (paymentScreen.style.transform === 'translateY(100%)') {
        paymentScreen.style.transform = 'translateY(0)';
    } else {
        paymentScreen.style.transform = 'translateY(100%)';
    }
}

document.getElementById('paymentButton').addEventListener('click', function() {
    togglePaymentScreen();
});

document.getElementById('closeButton').addEventListener('click', function() {
    togglePaymentScreen();
});

document.getElementById('transferForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Previne o envio padrão do formulário

    // Obter valores dos campos de entrada
    var email = document.getElementById('emailInput').value;
    var amount = document.getElementById('amountInput').value;
    var balance = parseFloat('<?php echo $_SESSION["balance"]; ?>');

    // Verificar se os campos não estão vazios
    if (email.trim() === '' || amount.trim() === '') {
        alert('Por favor, preencha todos os campos.');
        return; // Sai da função se algum campo estiver vazio
    }

    // Verificar saldo antes de mostrar a lightbox
    if (parseFloat(amount) > balance) {
        alert('Saldo insuficiente.');
        return; // Sai da função se o saldo for insuficiente
    }

    // Exibir a lightbox de loading
    var lightbox = document.getElementById('paymentLightbox');
    var loadingAnimation = document.getElementById('loadingAnimation');
    var successMessage = document.getElementById('successMessage');
    var errorMessage = document.getElementById('errorMessage');

    lightbox.style.display = 'flex';
    loadingAnimation.style.display = 'block';
    successMessage.style.display = 'none';
    errorMessage.style.display = 'none';

    // Enviar os dados via AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../DBConnection/transfer.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        // Simular um tempo de espera de 2 segundos
        setTimeout(function() {
            loadingAnimation.style.display = 'none';
    
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
    
                if (response.status === 'success') {
                    successMessage.style.display = 'block';
    
                    setTimeout(function() {
                        lightbox.style.display = 'none';
                        togglePaymentScreen();
                        // Resetar os campos de entrada após o envio bem-sucedido
                        document.getElementById('emailInput').value = '';
                        document.getElementById('amountInput').value = '';
                    }, 2000); // Fechar a lightbox após 2 segundos
                } else {
                    errorMessage.querySelector('p').innerText = response.message;
                    errorMessage.style.display = 'block';
    
                    // Fechar a lightbox após exibir o erro
                    setTimeout(function() {
                        lightbox.style.display = 'none';
                    }, 2000); // Fechar a lightbox após 2 segundos
                }
            } else {
                errorMessage.querySelector('p').innerText = 'Erro ao processar a requisição'
                errorMessage.style.display = 'block';
    
                // Fechar a lightbox após exibir o erro
                setTimeout(function() {
                    lightbox.style.display = 'none';
                }, 2000); // Fechar a lightbox após 2 segundos
            }
        }, 2000); // Simula 2 segundos de tempo de processamento
    };

    xhr.send('email=' + encodeURIComponent(email) + '&amount=' + encodeURIComponent(amount));
});

//Voltar pagina
document.addEventListener('DOMContentLoaded', function () {
    const backIcon = document.getElementById('back-icon');

    backIcon.addEventListener('click', function () {
        // Redireciona para a próxima página após um pequeno atraso
        setTimeout(() => {
            window.location.href = 'home_page.php'; 
        }, 250); 
    });
});
