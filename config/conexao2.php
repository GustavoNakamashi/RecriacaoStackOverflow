<?php
// config/conexao2.php - Configuração do banco de dados

$host = '189.45.123.67';
$dbname = 'stackoverflow_fatec';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    // Opcional: descomente a linha abaixo para testar a conexão
    // echo "Conectado com sucesso!";
} catch(PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>