<?php
session_start();

// Proteção da Página
if (!isset($_SESSION['id_paciente'])) {
    header("Location: login.php");
    exit();
}

require_once '../config/conexao.php';

$id_paciente = $_SESSION['id_paciente'];

try {
    // Busca os agendamentos e junta o diagnóstico se existir
    $sql = "SELECT a.*, m.nome AS nome_medico, m.especialidade, r.diagnostico
            FROM agendamentos a
            JOIN medicos m ON a.id_medico = m.id_medico
            LEFT JOIN resultados_consultas r ON a.id_agendamento = r.id_agendamento
            WHERE a.id_paciente = :id_paciente
            ORDER BY a.data_consulta DESC, a.hora_consulta DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_paciente' => $id_paciente]);
    $consultas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $consultas = [];
    $erro_sistema = "Erro ao carregar o histórico de agendamentos: " . $e->getMessage();
}

// Configurações do cabeçalho
$pagina_titulo = "Painel do Paciente";
$tipo_usuario = "paciente";
$pagina_ativa = "dashboard";

require_once '../includes/cabecalho.php';
?>

<div class="painel-header">
    <div class="painel-header-info">
        <h1>O Seu Painel de Saúde</h1>
        <p>Gerir as suas consultas e acompanhar diagnósticos no portal do paciente.</p>
    </div>
    <a href="marcar_consulta.php" class="btn-hero-primario">
        ➕ Marcar Nova Consulta
    </a>
</div>

<?php if (isset($erro_sistema)): ?>
    <div class="msg-erro"><?php echo $erro_sistema; ?></div>
<?php endif; ?>

<div class="painel-card">
    <h2 class="painel-card-titulo">As Suas Consultas e Histórico</h2>

    <?php if (count($consultas) > 0): ?>
        <div class="tabela-responsiva">
            <table class="tabela-dados">
                <thead>
                    <tr>
                        <th>Data / Hora</th>
                        <th>Médico</th>
                        <th>Especialidade</th>
                        <th>Estado</th>
                        <th>Diagnóstico</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($consultas as $consulta): ?>
                        <tr>
                            <td style="font-weight: 600;">
                                <?php echo date('d/m/Y', strtotime($consulta['data_consulta'])); ?> às <?php echo date('H:i', strtotime($consulta['hora_consulta'])); ?>
                            </td>
                            <td>Dr(a). <?php echo htmlspecialchars($consulta['nome_medico']); ?></td>
                            <td><?php echo htmlspecialchars($consulta['especialidade']); ?></td>
                            <td>
                                <?php
                                $status = $consulta['status_agendamento'];
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
                            <td style="color: var(--texto-cinza);">
                                <?php echo !empty($consulta['diagnostico']) ? htmlspecialchars($consulta['diagnostico']) : "<em>Sem registo disponível</em>"; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div style="text-align: center; padding: 40px 20px; color: var(--texto-cinza);">
            <span style="font-size: 48px; display: block; margin-bottom: 15px;">📅</span>
            <p style="font-size: 16px; font-weight: 500;">Ainda não tem nenhum agendamento efetuado.</p>
        </div>
    <?php endif; ?>
</div>

<?php
require_once '../includes/rodape.php';
?>