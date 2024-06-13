document.addEventListener('DOMContentLoaded', function () {
    const backIcon = document.getElementById('back-icon');

    // Função para obter o valor de um parâmetro de consulta na URL
    function obterParametroUrl(nome) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(nome);
    }

    // Obtém o ID passado pela URL
    const objetivoId = obterParametroUrl('id');

    // Conteúdos das opções
    const conteudos = {
        opcao1: {
            img: '../images/bills.png',
            texto: 'Bills'
        },
        opcao2: {
            img: '../images/repair.png',
            texto: 'Repairs and Renovations'
        },
        opcao3: {
            img: '../images/business.png',
            texto: 'Invest in my business'
        },
        opcao4: {
            img: '../images/travel.png',
            texto: 'Travel'
        },
        opcao5: {
            img: '../images/debts.png',
            texto: 'Debts'
        },
        opcao6: {
            img: '../images/medical.png',
            texto: 'Medical Services'
        },
        opcao7: {
            img: '../images/others.png',
            texto: 'Other'
        }
    };

    // Seleciona o objetivo e insere o conteúdo correspondente
    const objetivo = document.getElementById('Objetivo');
    const conteudo = conteudos[objetivoId];

    if (objetivo && conteudo) {
        const imgElement = document.createElement('img');
        imgElement.src = conteudo.img;
        imgElement.alt = conteudo.texto;

        const h3Element = document.createElement('h3');
        h3Element.textContent = conteudo.texto;

        objetivo.appendChild(imgElement);
        objetivo.appendChild(h3Element);
    } else {
        console.log('ID inválido ou não encontrado.');
    }

    // Adicione eventos de clique aos ícones de navegação
    backIcon.addEventListener('click', function () {
        // Voltar para a página anterior
        history.back();
    });

    // Definir o valor inicial do campo de valor monetário como R$ 00,00
    const amountInput = document.getElementById('amountInput');
    amountInput.value = 'R$ 00,00';
});

// Função para formatar o CPF
function formatarCPF(campo) {
    let cpf = campo.value.replace(/\D/g, '');
    cpf = cpf.substring(0, 11);
    cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
    cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
    cpf = cpf.replace(/(\d{3})(\d{1,2})/, '$1-$2');
    campo.value = cpf;
}

// Função para permitir apenas números e pontos no campo de valor monetário
function onlyNumbersAndDots(event) {
    const key = event.key;
    if (isNaN(key) && key !== '.') {
        event.preventDefault();
    }
}

// Função para formatar o campo de valor monetário
function formatCurrency(input) {
   // Remove todos os caracteres não numéricos
    let value = input.value.replace(/\D/g, '');

   // Transforma em número e divide por 100 para obter o valor decimal
    value = parseFloat(value / 100).toFixed(2);

   // Substitui o ponto por vírgula (para separador decimal correto)
    value = value.replace('.', ',');
    value = value.replace(',', '.');
   // Adiciona o símbolo de moeda e define o valor no input
    input.value = 'R$ ' + value;
    console.log(value);
}

document.getElementById('sendButton').addEventListener('click', function(event) {
    event.preventDefault();

    // Obter valores dos campos de entrada
    var email = document.getElementById('emailInput').value;
    var amount = document.getElementById('amountInput').value;
    var cpf = document.getElementById('cpfInput').value;
    var name = document.getElementById('nameInput').value;

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
    xhr.open('POST', '../DBConnection/loanverification.php', true);
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
                        window.location.href = 'loan_page.php'; // Redirecionar para a página de empréstimo
                    }, 2000); // Fechar a lightbox após 2 segundos
                } else {
                    errorMessage.querySelector('p').innerText = response.message;
                    errorMessage.style.display = 'block';

                    // Fechar a lightbox após exibir o erro
                    setTimeout(function() {
                        lightbox.style.display = 'none';
                    }, 2000); // Fechar a lightbox após 4 segundos (ajuste o tempo conforme necessário)
                }
            } else {
                errorMessage.querySelector('p').innerText = 'Erro ao processar a requisição';
                errorMessage.style.display = 'block';

                // Fechar a lightbox após exibir o erro
                setTimeout(function() {
                    lightbox.style.display = 'none';
                }, 2000); // Fechar a lightbox após 4 segundos (ajuste o tempo conforme necessário)
            }
        }, 2000); // Simula 2 segundos de tempo de processamento
    };

    // Montar os dados a serem enviados
    var formData =  'email=' + encodeURIComponent(email) +
                    '&amount=' + encodeURIComponent(amount) +
                    '&cpf=' + encodeURIComponent(cpf) +
                    '&name=' + encodeURIComponent(name);

    xhr.send(formData);
});