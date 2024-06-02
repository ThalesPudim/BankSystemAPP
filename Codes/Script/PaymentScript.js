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

document.getElementById('sendButton').addEventListener('click', function() {
    // Obter valores dos campos de entrada
    var email = document.getElementById('emailInput').value;
    var amount = document.getElementById('amountInput').value;

    // Verificar se os campos não estão vazios
    if (email.trim() === '' || amount.trim() === '') {
        alert('Por favor, preencha todos os campos.');
        return; // Sai da função se algum campo estiver vazio
    }

    // Exibir a lightbox de loading
    var lightbox = document.getElementById('paymentLightbox');
    var loadingAnimation = document.getElementById('loadingAnimation');
    var successMessage = document.getElementById('successMessage');

    lightbox.style.display = 'flex';
    loadingAnimation.style.display = 'block';
    successMessage.style.display = 'none';

    // Simular um tempo de espera para o processamento do pagamento
    setTimeout(function() {
        loadingAnimation.style.display = 'none';
        successMessage.style.display = 'block';

        // Fechar a lightbox após 2 segundos
        setTimeout(function() {
            lightbox.style.display = 'none';
            togglePaymentScreen();
            // Resetar os campos de entrada após o envio bem-sucedido
            document.getElementById('emailInput').value = '';
            document.getElementById('amountInput').value = '';
        }, 2000);
    }, 3000); // Simula 3 segundos de tempo de processamento
});