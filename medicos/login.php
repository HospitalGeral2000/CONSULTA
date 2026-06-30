<?php
session_start();

// Se o médico já estiver logado, manda direto para o dashboard dele
if (isset($_SESSION['id_medico'])) {
    header("Location: dashboard.php");
    exit();
}

require_once '../config/conexao.php';

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    if (!empty($email) && !empty($senha)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM medicos WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $medico = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($medico && password_verify($senha, $medico['senha'])) {
                $_SESSION['id_medico']        = $medico['id_medico'];
                $_SESSION['nome_medico']      = $medico['nome'];
                $_SESSION['especialidade']    = $medico['especialidade'];
                $_SESSION['especialidade_medico'] = $medico['especialidade'];

                header("Location: dashboard.php");
                exit();
            } else {
                $mensagem = "<div class='msg-erro'>E-mail ou Palavra-passe incorretos.</div>";
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
    <title>Acesso Médico — Hospital Digital</title>
    <link rel="stylesheet" href="../assets/css/estilo.css">
</head>

<body>

    <div class="container-form">
        <div class="card-formulario">

            <div class="form-cabecalho">
                <span class="form-icone">👨‍⚕️</span>
                <h2>Portal do Médico</h2>
                <p>Área restrita para o corpo clínico e consultas</p>
            </div>

            <?php echo $mensagem; ?>

            <form action="login.php" method="POST">

                <div class="form-grupo">
                    <label for="email">E-mail Profissional</label>
                    <input type="email" id="email" name="email" placeholder="exemplo@hgh.ao" required>
                </div>

                <div class="form-grupo">
                    <label for="senha">Palavra-passe</label>
                    <input type="password" id="senha" name="senha" placeholder="Introduza a sua senha" required>
                </div>

                <button type="submit" class="btn-entrar">
                    Entrar no Painel Clínico →
                </button>

                <div class="form-rodape-links">
                    Ainda não tem conta clínica? <a href="registo.php">Criar conta aqui</a>
                </div>

                <div class="form-voltar">
                    <a href="../index.php">Voltar à Página Inicial</a>
                </div>

            </form>

        </div>
    </div>

</body>

</html>