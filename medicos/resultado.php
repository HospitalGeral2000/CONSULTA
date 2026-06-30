<?php
session_start();

// Proteção da Página
if (!isset($_SESSION['id_medico'])) {
    header("Location: login.php");
    exit();
}

require_once '../config/conexao.php';

$id_medico = $_SESSION['id_medico'];
$nome_medico = $_SESSION['nome_medico'];
$especialidade = $_SESSION['especialidade_medico'];

$mensagem = "";
$historico = [];

try {
    // Busca todos os diagnósticos já realizados por este médico
    $sql = "SELECT r.*, a.data_consulta, a.hora_consulta, p.nome AS nome_paciente, p.bi AS bi_paciente
            FROM resultados_consultas r
            JOIN agendamentos a ON r.id_agendamento = a.id_agendamento
            JOIN pacientes p ON a.id_paciente = p.id_paciente
            WHERE a.id_medico = :id_medico
            ORDER BY a.data_consulta DESC, a.hora_consulta DESC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_medico' => $id_medico]);
    $historico = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $mensagem = "<div class='msg-erro'>Erro ao carregar histórico: " . $e->getMessage() . "</div>";
}

// Configurações do cabeçalho
$pagina_titulo = "Histórico de Resultados";
$tipo_usuario = "medico";
$pagina_ativa = "resultado";

require_once '../includes/cabecalho.php';
?>

<div class="painel-header">
    <div class="painel-header-info">
        <h1>Diagnósticos Emitidos</h1>
        <p>Consulte o histórico de laudos e receitas enviadas para os pacientes.</p>
    </div>
</div>

<?php echo $mensagem; ?>

<div class="painel-card">
    <h2 class="painel-card-titulo">Histórico de Atendimentos Concluídos</h2>

    <?php if (count($historico) > 0): ?>
        <div class="tabela-responsiva">
            <table class="tabela-dados">
                <thead>
                    <tr>
                        <th style="width: 180px;">Data do Atendimento</th>
                        <th style="width: 220px;">Paciente</th>
                        <th>Diagnóstico Clínico</th>
                        <th style="width: 250px;">Prescrição / Receita</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($historico as $item): ?>
                        <tr style="vertical-align: top;">
                            <td style="font-weight: 600;">
                                <?php echo date('d/m/Y', strtotime($item['data_consulta'])); ?><br>
                                <small style="color: var(--texto-cinza); font-weight: normal;">às <?php echo date('H:i', strtotime($item['hora_consulta'])); ?></small>
                            </td>
                            <td>
                                <strong><?php echo htmlspecialchars($item['nome_paciente']); ?></strong><br>
                                <small style="color: var(--texto-cinza);">BI: <?php echo htmlspecialchars($item['bi_paciente']); ?></small>
                            </td>
                            <td style="line-height: 1.5;">
                                <?php echo nl2br(htmlspecialchars($item['diagnostico'])); ?>
                            </td>
                            <td style="line-height: 1.5; color: var(--texto-cinza); font-size: 14px;">
                                <?php echo !empty($item['receita']) ? nl2br(htmlspecialchars($item['receita'])) : "<em>Nenhuma prescrição registada</em>"; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div style="text-align: center; padding: 40px 20px; color: var(--texto-cinza);">
            <span style="font-size: 48px; display: block; margin-bottom: 15px;">🩺</span>
            <p style="font-size: 16px; font-weight: 500;">Nenhum atendimento clínico concluído e registado até ao momento.</p>
        </div>
    <?php endif; ?>
</div>

<?php
require_once '../includes/rodape.php';
?>
