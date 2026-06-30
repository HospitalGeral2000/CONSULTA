<?php
// Configurações do Banco de Dados
$host    = 'localhost';
$db_name = 'hospital_huambo';
$usuario = 'root'; // Altera se o teu utilizador do MySQL for diferente
$senha   = '';     // Coloca a tua senha do MySQL se tiveres

try {
    // Criação da conexão usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $usuario, $senha);

    // Configura o PDO para lançar exceções em caso de erros SQL
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Define o modo de busca padrão para arrays associativos
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Caso a conexão falhe, exibe o erro
    die("Erro ao conectar à base de dados do Hospital: " . $e->getMessage());
}
