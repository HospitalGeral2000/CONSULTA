<?php
session_start();

// Se o médico já estiver logado, manda direto para o painel dele
if (isset($_SESSION['id_medico'])) {
    header("Location: dashboard.php");
    exit();
}

require_once '../config/conexao.php';

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome                  = trim($_POST['nome']);
    $especialidade         = trim($_POST['especialidade']);
    $carteira_profissional = trim($_POST['carteira_profissional']);
    $email                 = trim($_POST['email']);
    $senha                 = $_POST['senha'];

    if (!empty($nome) && !empty($especialidade) && !empty($carteira_profissional) && !empty($email) && !empty($senha)) {
        try {
            $stmt_verificar = $pdo->prepare("SELECT id_medico FROM medicos WHERE email = :email OR carteira_profissional = :carteira");
            $stmt_verificar->execute([':email' => $email, ':carteira' => $carteira_profissional]);

            if ($stmt_verificar->rowCount() > 0) {
                $mensagem = "<div class='msg-erro'>Erro: Este E-mail ou Carteira Profissional já estão registados.</div>";
            } else {
                $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

                $sql = "INSERT INTO medicos (nome, especialidade, carteira_profissional, email, senha) 
                        VALUES (:nome, :especialidade, :carteira_profissional, :email, :senha)";

                $stmt_inserir = $pdo->prepare($sql);
                $executou = $stmt_inserir->execute([
                    ':nome'                  => $nome,
                    ':especialidade'         => $especialidade,
                    ':carteira_profissional' => $carteira_profissional,
                    ':email'                 => $email,
                    ':senha'                 => $senha_hash
                ]);

                if ($executou) {
                    $mensagem = "<div class='msg-sucesso'>Conta de médico criada com sucesso! <a href='login.php'>Fazer Login</a>.</div>";
                }
            }
        } catch (PDOException $e) {
            $mensagem = "<div class='msg-erro'>Erro ao processar o registo: " . $e->getMessage() . "</div>";
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
    <title>Registo Médico — Hospital Digital</title>
    <link rel="stylesheet" href="../assets/css/estilo.css">
</head>

<body>

    <div class="container-form">
        <div class="card-formulario" style="max-width: 550px;">

            <div class="form-cabecalho">
                <span class="form-icone">🩺</span>
                <h2>Registo Clínico</h2>
                <p>Crie a sua conta de médico para gerir a sua agenda de consultas</p>
            </div>

            <?php echo $mensagem; ?>

            <form action="registo.php" method="POST">

                <div class="form-grupo">
                    <label for="nome">Nome Completo *</label>
                    <input type="text" id="nome" name="nome" placeholder="Dr. Nome do Médico" required>
                </div>

                <div class="form-grupo">
                    <label for="especialidade">Especialidade Médica *</label>
                    <select id="especialidade" name="especialidade" required>
                        <option value="">-- Selecione a Especialidade --</option>
                        <option value="Clínica Geral">Clínica Geral</option>
                        <option value="Pediatria">Pediatria</option>
                        <option value="Cardiologia">Cardiologia</option>
                        <option value="Ginecologia">Ginecologia</option>
                        <option value="Ortopedia">Ortopedia</option>
                    </select>
                </div>

                <div class="form-grupo">
                    <label for="carteira_profissional">Nº da Carteira Profissional (CRM/Ordem) *</label>
                    <input type="text" id="carteira_profissional" name="carteira_profissional" placeholder="Ex: CRM-AO-12345" required>
                </div>

                <div class="form-grupo">
                    <label for="email">E-mail Profissional *</label>
                    <input type="email" id="email" name="email" placeholder="exemplo@hgh.ao" required>
                </div>

                <div class="form-grupo">
                    <label for="senha">Palavra-passe de Acesso *</label>
                    <input type="password" id="senha" name="senha" placeholder="Crie uma senha segura" required>
                </div>

                <button type="submit" class="btn-hero-primario">
                    Finalizar Registo Médico ✓
                </button>

                <div class="form-rodape-links">
                    Já tem uma conta clínica? <a href="login.php">Fazer Login</a>
                </div>

                <div class="form-voltar">
                    <a href="../index.php">Voltar à Página Inicial</a>
                </div>

            </form>
        </div>
    </div>
</body>

</html>