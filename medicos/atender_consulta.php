<?php
session_start();

// Proteção da Página: Só médicos logados podem atender consultas
if (!isset($_SESSION['id_medico'])) {
    header("Location: login.php");
    exit();
}

require_once '../config/conexao.php';

$id_medico = $_SESSION['id_medico'];
$nome_medico = $_SESSION['nome_medico'];

$mensagem = "";
$consulta = null;

// Verifica se o ID do agendamento foi passado
if (isset($_GET['id'])) {
    $id_agendamento = (int)$_GET['id'];
    
    try {
        // Busca os detalhes do agendamento se for deste médico e estiver 'Confirmado'
        $sql = "SELECT a.*, p.nome AS nome_paciente, p.bi AS bi_paciente 
                FROM agendamentos a
                JOIN pacientes p ON a.id_paciente = p.id_paciente
                WHERE a.id_agendamento = :id_agendamento AND a.id_medico = :id_medico AND a.status_agendamento = 'Confirmado'";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_agendamento' => $id_agendamento, ':id_medico' => $id_medico]);
        $consulta = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$consulta) {
            $mensagem = "<div class='msg-erro'>Consulta não encontrada ou não está confirmada para atendimento.</div>";
        }
    } catch (PDOException $e) {
        $mensagem = "<div class='msg-erro'>Erro ao carregar consulta: " . $e->getMessage() . "</div>";
    }
} else {
    header("Location: dashboard.php");
    exit();
}

// Processa a submissão do diagnóstico
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $consulta) {
    $diagnostico = trim($_POST['diagnostico']);
    $receita     = trim($_POST['receita']);
    
    if (!empty($diagnostico)) {
        try {
            // Inicia uma transação para garantir que ambas as operações ocorram juntas
            $pdo->beginTransaction();
            
            // 1. Insere o diagnóstico na tabela de resultados_consultas
            $sql_resultado = "INSERT INTO resultados_consultas (id_agendamento, diagnostico, receita) 
                              VALUES (:id_agendamento, :diagnostico, :receita)";
            $stmt_res = $pdo->prepare($sql_resultado);
            $stmt_res->execute([
                ':id_agendamento' => $id_agendamento,
                ':diagnostico'    => $diagnostico,
                ':receita'        => !empty($receita) ? $receita : null
            ]);
            
            // 2. Atualiza o status do agendamento para 'Realizado'
            $sql_update = "UPDATE agendamentos 
                           SET status_agendamento = 'Realizado' 
                           WHERE id_agendamento = :id_agendamento";
            $stmt_up = $pdo->prepare($sql_update);
            $stmt_up->execute([':id_agendamento' => $id_agendamento]);
            
            $pdo->commit();
            
            // Redireciona de volta ao painel
            $_SESSION['sucesso_atendimento'] = "Atendimento da consulta de " . $consulta['nome_paciente'] . " finalizado com sucesso!";
            header("Location: dashboard.php");
            exit();
            
        } catch (PDOException $e) {
            $pdo->rollBack();
            $mensagem = "<div class='msg-erro'>Erro ao registar atendimento: " . $e->getMessage() . "</div>";
        }
    } else {
        $mensagem = "<div class='msg-erro'>Por favor, preencha o campo de diagnóstico.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atendimento Clínico — Hospital Geral do Huambo</title>
    <link rel="stylesheet" href="../assets/css/estilo.css">
</head>

<body style="background-color: var(--cinza-fundo); font-family: 'Inter', Arial, sans-serif;">

    <!-- Navbar do Painel -->
    <nav class="navbar scrolled" style="position: static; padding: 15px 8%;">
        <a href="dashboard.php" class="nav-logo">
            <div class="nav-logo-texto">HGH — <span>Atendimento</span></div>
        </a>
        <div class="nav-acoes">
            <span style="font-weight: bold; color: var(--texto-cinza);">Dr. <?php echo htmlspecialchars($nome_medico); ?></span>
            <a href="dashboard.php" style="color: var(--azul-primario); font-weight: bold; margin-left: 20px; font-size: 14px;">Voltar ao Painel</a>
        </div>
    </nav>

    <div class="container-form" style="min-height: calc(100vh - 80px);">
        <div class="card-formulario" style="max-width: 600px;">
            
            <div style="text-align: center; margin-bottom: 25px;">
                <span style="font-size: 40px;">🩺</span>
                <h2 style="color: var(--azul-primario); margin-top: 10px; font-size: 24px;">Ficha de Atendimento</h2>
                <p style="color: var(--texto-cinza); font-size: 14px; margin-top: 5px;">Registe as informações clínicas do paciente</p>
            </div>

            <?php echo $mensagem; ?>

            <?php if ($consulta): ?>
                <!-- Detalhes do Paciente -->
                <div style="background-color: var(--azul-claro); padding: 16px; border-radius: 8px; margin-bottom: 25px; border: 1px solid rgba(11, 76, 140, 0.08);">
                    <p style="font-size: 14px; margin-bottom: 6px; color: var(--texto-escuro);">
                        <strong>Paciente:</strong> <?php echo htmlspecialchars($consulta['nome_paciente']); ?>
                    </p>
                    <p style="font-size: 14px; margin-bottom: 6px; color: var(--texto-escuro);">
                        <strong>BI:</strong> <?php echo htmlspecialchars($consulta['bi_paciente']); ?>
                    </p>
                    <p style="font-size: 14px; color: var(--texto-escuro); margin-bottom: 0;">
                        <strong>Sintomas Relatados:</strong> <br>
                        <span style="color: var(--texto-cinza);">
                            <?php echo !empty($consulta['motivo_consulta']) ? nl2br(htmlspecialchars($consulta['motivo_consulta'])) : "<em>Não informado</em>"; ?>
                        </span>
                    </p>
                </div>

                <!-- Formulário de Atendimento -->
                <form action="atender_consulta.php?id=<?php echo $id_agendamento; ?>" method="POST">
                    
                    <div class="form-grupo">
                        <label for="diagnostico">Diagnóstico / Avaliação Clínica *</label>
                        <textarea id="diagnostico" name="diagnostico" rows="5" placeholder="Descreva o diagnóstico clínico do paciente..." required style="resize: none;"></textarea>
                    </div>

                    <div class="form-grupo" style="margin-bottom: 25px;">
                        <label for="receita">Receita Médica / Recomendações (Opcional)</label>
                        <textarea id="receita" name="receita" rows="4" placeholder="Escreva os medicamentos e orientações de dosagem..." style="resize: none;"></textarea>
                    </div>

                    <button type="submit" class="btn-entrar" style="width: 100%;">
                        Salvar e Concluir Consulta ✓
                    </button>

                    <div style="text-align: center; margin-top: 15px; font-size: 14px;">
                        <a href="dashboard.php" style="color: var(--texto-cinza); text-decoration: underline;">Cancelar e voltar</a>
                    </div>

                </form>
            <?php else: ?>
                <div style="text-align: center; padding: 20px;">
                    <a href="dashboard.php" class="btn-entrar">Voltar para o Painel</a>
                </div>
            <?php endif; ?>

        </div>
    </div>

</body>

</html>
