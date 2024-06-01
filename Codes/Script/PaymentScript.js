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
    togglePaymentScreen(); // Chamando a função para fechar a tela de pagamento
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

    // Aqui você pode adicionar a lógica para enviar os dados para o backend
    // Por enquanto, apenas exibindo os valores inseridos
    console.log('Email:', email);
    console.log('Quantia:', amount);

    // Resetar os campos de entrada após o envio bem-sucedido
    document.getElementById('emailInput').value = '';
    document.getElementById('amountInput').value = '';
});