// Função para mostrar/ocultar o painel lateral de perfil
function toggleProfilePanel() {
    var profilePanel = document.getElementById('profilePanel');
    var helpPanel = document.getElementById('helpPanel');
    
    // Fechar painel de ajuda se estiver aberto
    if (helpPanel.style.right === '0px') {
        closeHelpPanel();
    }

    if (profilePanel.style.left === '-300px') {
        profilePanel.style.left = '0';
    } else {
        profilePanel.style.left = '-300px';
    }
}

// Função para mostrar/ocultar o painel lateral de ajuda
function toggleHelpPanel() {
    var profilePanel = document.getElementById('profilePanel');
    var helpPanel = document.getElementById('helpPanel');
    
    // Fechar painel de perfil se estiver aberto
    if (profilePanel.style.left === '0px') {
        closeProfilePanel();
    }

    if (helpPanel.style.right === '-300px') {
        helpPanel.style.right = '0';
    } else {
        helpPanel.style.right = '-300px';
    }
}

// Função para fechar o painel lateral de perfil
function closeProfilePanel() {
    document.getElementById('profilePanel').style.left = '-300px';
}

// Função para fechar o painel lateral de ajuda
function closeHelpPanel() {
    document.getElementById('helpPanel').style.right = '-300px';
}

// Adicione um evento de clique na imagem do usuário para mostrar/ocultar o painel lateral de perfil
document.querySelector('.header img[alt="User"]').addEventListener('click', function() {
    toggleProfilePanel();
});

// Adicione um evento de clique na imagem de ajuda para mostrar/ocultar o painel lateral de ajuda
document.querySelector('.header img[alt="Help"]').addEventListener('click', function() {
    toggleHelpPanel();
});

// Adicione um evento de clique na página inicial para fechar os painéis laterais
document.querySelector('body').addEventListener('click', function(event) {
    // Verifique se o clique ocorreu fora dos painéis laterais
    if (!document.getElementById('profilePanel').contains(event.target) && 
        !document.getElementById('helpPanel').contains(event.target) &&
        event.target !== document.querySelector('.header img[alt="User"]') && 
        event.target !== document.querySelector('.header img[alt="Help"]')) {
        closeProfilePanel();
        closeHelpPanel();
    }
});

// Adicione eventos de toque para fechar os painéis laterais quando o usuário desliza para a esquerda ou direita
var touchstartX = 0;
var touchendX = 0;
var minSwipeDistance = 50; // Defina a distância mínima de deslize para fechar o painel lateral

document.addEventListener('touchstart', function(event) {
    touchstartX = event.changedTouches[0].screenX;
});

document.addEventListener('touchend', function(event) {
    touchendX = event.changedTouches[0].screenX;
    handleSwipe();
});

function handleSwipe() {
    if (touchendX < touchstartX && touchstartX - touchendX > minSwipeDistance) {
        closeProfilePanel();
    } else if (touchendX > touchstartX && touchendX - touchstartX > minSwipeDistance) {
        closeHelpPanel();
    }
}




document.addEventListener("DOMContentLoaded", function() {
    // Obtém uma referência ao botão de deslogar
    const logoutButton = document.getElementById('logoutButton');

    // Obtém uma referência à lightbox
    const lightbox = document.getElementById('logoutLightbox');

    // Adiciona um evento de clique ao botão de deslogar
    logoutButton.addEventListener('click', function() {
        // Imprime uma mensagem no console quando o botão de deslogar for clicado
        console.log("Botão de deslogar clicado");
        // Torna a lightbox visível
        lightbox.style.display = 'block';

        // Adiciona um evento de clique ao documento inteiro
        document.addEventListener('click', clickOutsideLightbox);

        // Função para fechar a lightbox se clicar fora dela
        function clickOutsideLightbox(event) {
            if (event.target === lightbox) {
                // Fecha a lightbox
                lightbox.style.display = 'none';
                // Remove o evento de clique do documento
                document.removeEventListener('click', clickOutsideLightbox);
            }
        }
    });

    // Obtém uma referência ao botão de fechar na lightbox
    const closeButton = document.getElementById('cancelButton');

    // Adiciona um evento de clique ao botão de fechar na lightbox
    closeButton.addEventListener('click', function() {
        // Torna a lightbox invisível novamente
        lightbox.style.display = 'none';
    });

    // Obtém uma referência ao botão "Cancelar" dentro da lightbox
    const cancelButton = document.getElementById('cancelButton');

    // Adiciona um evento de clique ao botão "Cancelar"
    cancelButton.addEventListener('click', function() {
        // Imprime uma mensagem no console quando o botão "Cancelar" for clicado
        // Fecha a lightbox sem fazer logout
        lightbox.style.display = 'none';
    });

    // Obtém uma referência ao botão "Sim" dentro da lightbox
    const confirmLogoutButton = document.getElementById('confirmLogoutButton');

    // Adiciona um evento de clique ao botão "Sim"
    confirmLogoutButton.addEventListener('click', function() {

        window.location.href = "login_page.html";
    });
});