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
    let value = input.value.replace(/\D/g, '');
    value = (value / 100).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
    input.value = 'R$ ' + value;
}

