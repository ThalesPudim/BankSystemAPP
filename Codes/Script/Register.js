document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('registerForm');
    const errorMessages = document.querySelectorAll('.error-message');

    form.addEventListener('submit', function (event) {
        let isValid = true;

        // Reset error messages
        errorMessages.forEach(function (errorMessage) {
            errorMessage.textContent = '';
        });

        // Validations
        const firstName = document.getElementById('firstName').value.trim();
        if (firstName === '') {
            showError('firstName', 'Por favor, insira seu primeiro nome.');
            isValid = false;
        }

        const lastName = document.getElementById('lastName').value.trim();
        if (lastName === '') {
            showError('lastName', 'Por favor, insira seu último nome.');
            isValid = false;
        }

        const birthday = document.getElementById('birthday').value.trim();
        if (birthday === '') {
            showError('birthday', 'Por favor, insira sua data de aniversário.');
            isValid = false;
        }

        const email = document.getElementById('email').value.trim();
        if (email === '') {
            showError('email', 'Por favor, insira seu email.');
            isValid = false;
        } else if (!isValidEmail(email)) {
            showError('email', 'Por favor, insira um email válido.');
            isValid = false;
        }

        const cpfInput = document.getElementById('cpf');
        const cpf = cpfInput.value.trim().replace(/[^\d]/g, '')
        cpfInput.value = cpf;
        if (cpf === '') {
            showError('cpf', 'Por favor, insira seu CPF.');
            isValid = false;
        } else if (!isValidCPF(cpf)) {
            showError('cpf', 'Por favor, insira um CPF válido.');
            isValid = false;
        }

        const password = document.getElementById('password').value.trim();
        if (password === '') {
            showError('password', 'Por favor, insira sua senha.');
            isValid = false;
        }

        const gender = document.getElementById('gender').value;
        if (gender === '') {
            showError('gender', 'Por favor, selecione seu gênero.');
            isValid = false;
        }

        const accountType = document.getElementById('accountType').value;
        if (accountType === '') {
            showError('accountType', 'Por favor, selecione o tipo de conta.');
            isValid = false;
        }

        if (!isValid) {
            event.preventDefault(); // Prevent form submission if there are errors
        }
    });

    function showError(inputId, message) {
        const errorMessage = document.querySelector(`#${inputId}.error-message`);
        errorMessage.textContent = message;
        const inputField = document.getElementById(inputId);
        inputField.classList.add('error');
    }

    function isValidEmail(email) {
        // Basic email validation using regex
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function isValidCPF(cpf) {
        // Basic CPF validation (assuming format XXX.XXX.XXX-XX)
        const cpfRegex = /^\d{3}\.\d{3}\.\d{3}-\d{2}$/;
        return cpfRegex.test(cpf);
    }
});