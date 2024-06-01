<?php
// db_connection.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "HringBank";

// Cria conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>