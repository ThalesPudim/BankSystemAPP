<?php
// Inclui o arquivo de conexão
include 'dbconnection.php';

// Verificar se o método de requisição é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receber dados do formulário
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $birthday = $_POST['birthday'];
    $street = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zipcode = $_POST['zipcode'];
    $country = $_POST['country'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $accountType = $_POST['accountType'];

    // Verificar se o endereço já existe na tabela Address
    $addressId = null;
    $addressQuery = "SELECT AddressID FROM Address WHERE Street = '$street' AND City = '$city' AND State = '$state' AND ZipCode = '$zipcode' AND Country = '$country'";
    $addressResult = $conn->query($addressQuery);

    if ($addressResult->num_rows > 0) {
        // Endereço já existe, obter o ID do endereço existente
        $addressRow = $addressResult->fetch_assoc();
        $addressId = $addressRow['AddressID'];
    } else {
        // Endereço não existe, inserir um novo endereço
        $insertAddressQuery = "INSERT INTO Address (Street, City, State, ZipCode, Country) VALUES ('$street', '$city', '$state', '$zipcode', '$country')";
        if ($conn->query($insertAddressQuery) === TRUE) {
            // Obter o ID do novo endereço inserido
            $addressId = $conn->insert_id;
        } else {
            echo "Erro ao inserir endereço: " . $conn->error;
            exit(); // Encerrar a execução em caso de erro
        }
    }

    // Query para inserir os dados do usuário, usando o ID do endereço
    $insertUserQuery = "INSERT INTO Users (FirstName, LastName, DateOfBirth, AddressID, Email, CPF, UserPassword, Gender, Balance, AccountTypeID) 
                        VALUES ('$firstName', '$lastName', '$birthday', $addressId, '$email', '$cpf', '$password', $gender, 0, $accountType)";

    if ($conn->query($insertUserQuery) === TRUE) {
        echo "Registro criado com sucesso.";
    } else {
        echo "Erro ao criar registro: " . $conn->error;
    }
}

// Fechar conexão
$conn->close();
?>