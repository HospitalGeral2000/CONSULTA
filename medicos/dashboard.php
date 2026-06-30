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

// Processa a alteração de estado (Confirmar / Cancelar) antes de listar
if (isset($_GET['acao']) && isset($_GET['id'])) {
    $acao = $_GET['acao'];
    $id_agenda = (int)$_GET['id'];

    $novo_status = "";
    if ($acao === 'confirmar') $novo_status = 'Confirmado';
    if ($acao === 'cancelar') $novo_status = 'Cancelado';

    if (!empty($novo_status)) {
        try {
            $stmt_update = $pdo->prepare("UPDATE agendamentos SET status_agendamento = :status WHERE id_agendamento = :id AND id_medico = :id_medico");
            $stmt_update->execute([':status' => $novo_status, ':id' => $id_agenda, ':id_medico' => $id_medico]);
            header("Location: dashboard.php");
            exit();
        } catch (PDOException $e) {
            $mensagem = "<div class='msg-erro'>Erro ao atualizar estado: " . $e->getMessage() . "</div>";
        }
    }
}

try {
    $sql = "SELECT a.*, p.nome AS nome_paciente, p.bi AS bi_paciente, p.telefone AS tel_paciente 
            FROM agendamentos a
            JOIN pacientes p ON a.id_paciente = p.id_paciente
            WHERE a.id_medico = :id_medico
            ORDER BY a.data_consulta ASC, a.hora_consulta ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_medico' => $id_medico]);
    $agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $agendamentos = [];
    $mensagem = "<div class='msg-erro'>Erro ao carregar agenda: " . $e->getMessage() . "</div>";
}

// Configurações do cabeçalho
$pagina_titulo = "Painel Clínico";
$tipo_usuario = "medico";
$pagina_ativa = "dashboard";

require_once '../includes/cabecalho.php';
?>

<div class="painel-header">
    <div class="painel-header-info">
        <h1>Gestão de Consultas</h1>
        <p>Especialidade: <strong><?php echo htmlspecialchars($especialidade); ?></strong> · Controle os pedidos de agendamento e realize os atendimentos clínicos.</p>
    </div>
</div>

<?php
if (isset($_SESSION['sucesso_atendimento'])) {
    echo "<div class='msg-sucesso'>" . htmlspecialchars($_SESSION['sucesso_atendimento']) . "</div>";
    unset($_SESSION['sucesso_atendimento']);
}
echo $mensagem;
?>

<div class="painel-card">
    <h2 class="painel-card-titulo">Lista de Pacientes Marcados</h2>

    <?php if (count($agendamentos) > 0): ?>
        <div class="tabela-responsiva">
            <table class="tabela-dados">
                <thead>
                    <tr>
                        <th>Data / Hora</th>
                        <th>Paciente</th>
                        <th>Contacto</th>
                        <th>Sintomas/Motivo</th>
                        <th>Estado</th>
                        <th style="text-align: center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($agendamentos as $agenda): ?>
                        <tr>
                            <td style="font-weight: 600;">
                                <?php echo date('d/m/Y', strtotime($agenda['data_consulta'])); ?><br>
                                <small style="color: var(--texto-cinza); font-weight: normal;"><?php echo date('H:i', strtotime($agenda['hora_consulta'])); ?></small>
                            </td>
                            <td>
                                <strong><?php echo htmlspecialchars($agenda['nome_paciente']); ?></strong><br>
                                <small style="color: var(--texto-cinza);">BI: <?php echo htmlspecialchars($agenda['bi_paciente']); ?></small>
                            </td>
                            <td><?php echo htmlspecialchars($agenda['tel_paciente']); ?></td>
                            <td style="color: var(--texto-cinza); font-size: 14px;">
                                <?php echo !empty($agenda['motivo_consulta']) ? htmlspecialchars($agenda['motivo_consulta']) : "<em>Não informado</em>"; ?>
                            </td>
                            <td>
                                <?php
                                $status = $agenda['status_agendamento'];
                                if ($status === 'Pendente') {
                                    echo "<span class='status-badge status-pendente'>Pendente</span>";
                                } elseif ($status === 'Confirmado') {
                                    echo "<span class='status-badge status-confirmado'>Confirmado</span>";
                                } elseif ($status === 'Realizado') {
                                    echo "<span class='status-badge status-realizado'>Realizado</span>";
                                } else {
                                    echo "<span class='status-badge status-cancelado'>Cancelado</span>";
                                }
                                ?>
                            </td>
                            <td style="text-align: center;">
                                <?php if ($status === 'Pendente'): ?>
                                    <a href="dashboard.php?acao=confirmar&id=<?php echo $agenda['id_agendamento']; ?>" style="color: var(--verde-sucesso); font-weight: 600; margin-right: 12px; font-size: 14px;">✓ Confirmar</a>
                                    <a href="dashboard.php?acao=cancelar&id=<?php echo $agenda['id_agendamento']; ?>" style="color: var(--vermelho-erro); font-weight: 600; font-size: 14px;" onclick="return confirm('Tem certeza que deseja cancelar esta consulta?')">✕ Cancelar</a>
                                <?php elseif ($status === 'Confirmado'): ?>
                                    <a href="atender_consulta.php?id=<?php echo $agenda['id_agendamento']; ?>" class="btn-hero-primario" style="padding: 8px 16px; font-size: 13px;">🩺 Atender</a>
                                <?php else: ?>
                                    <span style="color: var(--texto-cinza); font-size: 13px;">Sem ações</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div style="text-align: center; padding: 40px 20px; color: var(--texto-cinza);">
            <span style="font-size: 48px; display: block; margin-bottom: 15px;">📅</span>
            <p style="font-size: 16px; font-weight: 500;">Nenhum paciente agendado para o seu perfil até ao momento.</p>
        </div>
    <?php endif; ?>
</div>

<?php
require_once '../includes/rodape.php';
?>