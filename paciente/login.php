<?php
// 1. Inicia a sessão para permitir guardar os dados do utilizador logado
session_start();

// Redireciona para o painel se o paciente já estiver com uma sessão ativa
if (isset($_SESSION['id_paciente'])) {
    header("Location: dashboard.php");
    exit();
}

// 2. Inclui a conexão com a base de dados
require_once '../config/conexao.php';

$mensagem = "";

// 3. Processa o envio do formulário de Login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bi    = trim($_POST['bi']);
    $senha = $_POST['senha'];

    if (!empty($bi) && !empty($senha)) {
        try {
            // Procura o paciente pelo número de BI
            $stmt = $pdo->prepare("SELECT * FROM pacientes WHERE bi = :bi");
            $stmt->execute([':bi' => $bi]);
            $paciente = $stmt->fetch(PDO::FETCH_ASSOC);

            // Se o paciente existir, valida a senha com a versão encriptada
            if ($paciente && password_verify($senha, $paciente['senha'])) {

                // Cria as variáveis de sessão para identificar o utilizador nas outras páginas
                $_SESSION['id_paciente']   = $paciente['id_paciente'];
                $_SESSION['nome_paciente'] = $paciente['nome'];
                $_SESSION['bi_paciente']   = $paciente['bi'];

                // Redireciona o utilizador para o Dashboard (Painel Principal)
                header("Location: dashboard.php");
                exit();
            } else {
                $mensagem = "<div class='msg-erro'>Nº de BI ou Palavra-passe incorretos.</div>";
            }
        } catch (PDOException $e) {
            $mensagem = "<div class='msg-erro'>Erro no sistema: " . $e->getMessage() . "</div>";
        }
    } else {
        $mensagem = "<div class='msg-erro'>Por favor, preencha todos os campos.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aceder ao Sistema — Hospital Digital</title>
    <link rel="stylesheet" href="../assets/css/estilo.css">
</head>

<body>

    <div class="container-form">
        <div class="card-formulario">

            <div class="form-cabecalho">
                <span class="form-icone"> </span>
                <h2>Iniciar Sessão</h2>
                <p>Introduza as suas credenciais para aceder ao portal do paciente</p>
            </div>

            <?php echo $mensagem; ?>

            <form action="login.php" method="POST">

                <div class="form-grupo">
                    <label for="bi">Nº do Bilhete de Identidade</label>
                    <input type="text" id="bi" name="bi" placeholder="Introduza o seu BI" required>
                </div>

                <div class="form-grupo">
                    <label for="senha">Password</label>
                    <input type="password" id="senha" name="senha" placeholder="Introduza a sua palavra-passe" required>
                </div>

                <button type="submit" class="btn-entrar">
                    Entrar no Sistema →
                </button>

                <div class="form-rodape-links">
                    Ainda não tem conta? <a href="registo.php">Criar conta aqui</a>
                </div>

                <div class="form-voltar">
                    <a href="../index.php">Voltar à Página Inicial</a>
                </div>

            </form>

        </div>
    </div>

</body>

</html>