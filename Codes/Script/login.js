// Função para fazer o login
function login() {
    // Captura os valores dos campos de entrada
    var email = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    // Verifica se os campos não estão vazios
    if (email.trim() === '' || password.trim() === '') {
        alert("Por favor, preencha todos os campos.");
        return;
    }

    // Envia os dados para o servidor
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./../DbConnection/login.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Recebe a resposta do servidor
            var response = xhr.responseText;
            if (response === "success") {
                // Redireciona para a página de sucesso
                window.location.href = "home_page.html";
            } else {
                // Exibe uma mensagem de erro
                alert("E-mail ou senha incorretos. Por favor, tente novamente.");
            }
        }
    };
    // Envia os dados do formulário para o servidor
    var data = "email=" + email + "&password=" + password;
    xhr.send(data);
}