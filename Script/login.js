
function login() {
        var username = document.getElementById("username").value;
        var password = document.getElementById("password").value;

        // lógica de verificação de login

        // Exemplo simples: Se o campo de nome de usuário e senha não estiverem vazios, redirecione para a página principal
        if (username.trim() !== "" && password.trim() !== "") {
            window.location.href = "home_page.html"; // Substitua "pagina_principal.html" pelo caminho da sua página principal
        } else {
            alert("Por favor, preencha todos os campos."); // Mostrar mensagem de erro se os campos estiverem vazios
        }
    }

// Adicionando um ouvinte de evento para o botão de login
document.getElementById("loginButton").addEventListener("click", login);