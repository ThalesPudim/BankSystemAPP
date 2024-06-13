// Seleciona todas as divs de objetivos
const objetivos = document.querySelectorAll('.objetivos');

// Adiciona um ouvinte de eventos de clique a cada div de objetivo
objetivos.forEach(objetivo => {
    objetivo.addEventListener('click', () => {
        // Remove a classe 'selecionado' de todas as divs de objetivos
    objetivos.forEach(obj => {
        obj.classList.remove('selecionado');
    });
    // Adiciona a classe 'selecionado' apenas à div de objetivo clicada
    objetivo.classList.add('selecionado');
    });
});

//Voltar pagina
document.addEventListener('DOMContentLoaded', function () {
    const backIcon = document.getElementById('back-icon');

    backIcon.addEventListener('click', function () {
        // Redireciona para a próxima página após um pequeno atraso
        setTimeout(() => {
            window.location.href = 'loan_page.php'; 
        }, 250); 
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const backIcon = document.getElementById('continue-icon');

    backIcon.addEventListener('click', function () {
        // Obtém a div de objetivo selecionada
        const objetivoSelecionado = document.querySelector('.objetivos.selecionado');
        
        // Verifica se pelo menos uma div de objetivo está selecionada
        if (objetivoSelecionado) {
            // Obtém o ID da div de objetivo selecionada
            const objetivoId = objetivoSelecionado.id;
            
            // Redireciona para a próxima página com o ID como parâmetro de consulta na URL
            setTimeout(() => {
                window.location.href = `loan_simulation.php?id=${objetivoId}`;
            }, 250);
        } else {
            // Se nenhuma opção foi selecionada, mostra uma mensagem de erro ou realiza outra ação
            console.log('Por favor, selecione uma opção antes de continuar.');
        }
    });
});