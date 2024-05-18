document.getElementById("loginButton").addEventListener("click", function() {
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    fetch('/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'username': username,
            'password': password
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            // Redireciona para a página home_page.html
            window.location.href = 'home_page.html';
        } else {
            alert("Login ou senha incorretos!");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("Ocorreu um erro ao tentar fazer login.");
    });
});