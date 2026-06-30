<?php
// 1. Inclui o ficheiro de conexão (ajustando o caminho para a pasta config)
require_once '../config/conexao.php';

$mensagem = "";

// 2. Processa os dados quando o formulário é enviado (Método POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome     = trim($_POST['nome']);
    $bi       = trim($_POST['bi']);
    $telefone = trim($_POST['telefone']);
    $email    = trim($_POST['email']);
    $senha    = $_POST['senha'];

    // Validação básica para garantir que nenhum campo obrigatório vai vazio
    if (!empty($nome) && !empty($bi) && !empty($telefone) && !empty($senha)) {
        try {
            // Verifica se o BI já está cadastrado no sistema
            $stmt_verificar = $pdo->prepare("SELECT id_paciente FROM pacientes WHERE bi = :bi");
            $stmt_verificar->execute([':bi' => $bi]);

            if ($stmt_verificar->rowCount() > 0) {
                $mensagem = "<div class='msg-erro'>Erro: Este número de BI já está registado no sistema.</div>";
            } else {
                // Encripta a senha usando a criptografia nativa e segura do PHP (BCRYPT)
                $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

                // Prepara o SQL para inserção segura (evitando SQL Injection)
                $sql = "INSERT INTO pacientes (nome, bi, telefone, email, senha) 
                        VALUES (:nome, :bi, :telefone, :email, :senha)";

                $stmt = $pdo->prepare($sql);

                $executou = $stmt->execute([
                    ':nome'     => $nome,
                    ':bi'       => $bi,
                    ':telefone' => $telefone,
                    ':email'    => !empty($email) ? $email : null, // Email é opcional
                    ':senha'    => $senha_hash
                ]);

                if ($executou) {
                    $mensagem = "<div class='msg-sucesso'>Conta criada com sucesso! <a href='login.php'>Clique aqui para entrar</a>.</div>";
                }
            }
        } catch (PDOException $e) {
            $mensagem = "<div class='msg-erro'>Erro ao processar o registo: " . $e->getMessage() . "</div>";
        }
    } else {
        $mensagem = "<div class='msg-erro'>Por favor, preencha todos os campos obrigatórios.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta — Hospital Digital</title>
    <link rel="stylesheet" href="../assets/css/estilo.css">
</head>

<body>

    <div class="container-form">
        <div class="card-formulario">

            <div class="form-cabecalho">
                <span class="form-icone"></span>
                <h2>Criar Conta</h2>
                <p>Introduza os seus dados para aceder ao sistema de marcação</p>
            </div>

            <?php echo $mensagem; ?>

            <form action="registo.php" method="POST">

                <div class="form-grupo">
                    <label for="nome">Nome Completo *</label>
                    <input type="text" id="nome" name="nome" placeholder="Ex: Manuel António" required>
                </div>

                <div class="form-grupo">
                    <label for="bi">Nº do Bilhete de Identidade *</label>
                    <input type="text" id="bi" name="bi" placeholder="Ex: 001234567HA040" required>
                </div>

                <div class="form-grupo">
                    <label for="telefone">Número de Telefone *</label>
                    <input type="tel" id="telefone" name="telefone" placeholder="Ex: 923000000" required>
                </div>

                <div class="form-grupo">
                    <label for="email">E-mail (Opcional)</label>
                    <input type="email" id="email" name="email" placeholder="Ex: nome@exemplo.com">
                </div>

                <div class="form-grupo">
                    <label for="senha">Palavra-passe *</label>
                    <input type="password" id="senha" name="senha" placeholder="Crie uma senha segura" required>
                </div>

                <button type="submit" class="btn-cadastro">
                    Cadastrar-se
                </button>

                <div class="form-rodape-links">
                    Já tem uma conta? <a href="login.php">Entrar aqui</a>
                </div>

                <div class="form-voltar">
                    <a href="../index.php">Voltar à Página Inicial</a>
                </div>

            </form>

        </div>
    </div>

</body>

</html>