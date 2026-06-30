<?php
session_start();

// Proteção da Página
if (!isset($_SESSION['id_paciente'])) {
    header("Location: login.php");
    exit();
}

require_once '../config/conexao.php';

$id_paciente = $_SESSION['id_paciente'];
$mensagem = "";

try {
    $stmt_medicos = $pdo->query("SELECT id_medico, nome, especialidade FROM medicos ORDER BY especialidade, nome");
    $medicos = $stmt_medicos->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $medicos = [];
    $mensagem = "<div class='msg-erro'>Erro ao carregar médicos.</div>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_medico       = $_POST['id_medico'];
    $data_consulta   = $_POST['data_consulta'];
    $hora_consulta   = $_POST['hora_consulta'];
    $motivo_consulta = trim($_POST['motivo_consulta']);

    if (!empty($id_medico) && !empty($data_consulta) && !empty($hora_consulta)) {
        try {
            $sql_inserir = "INSERT INTO agendamentos (id_paciente, id_medico, data_consulta, hora_consulta, motivo_consulta, status_agendamento) 
                            VALUES (:id_paciente, :id_medico, :data_consulta, :hora_consulta, :motivo_consulta, 'Pendente')";

            $stmt_inserir = $pdo->prepare($sql_inserir);
            $executou = $stmt_inserir->execute([
                ':id_paciente'     => $id_paciente,
                ':id_medico'       => $id_medico,
                ':data_consulta'   => $data_consulta,
                ':hora_consulta'   => $hora_consulta,
                ':motivo_consulta' => !empty($motivo_consulta) ? $motivo_consulta : null
            ]);

            if ($executou) {
                $mensagem = "<div class='msg-sucesso'>Solicitação enviada! Aguarde a confirmação da equipa médica. <a href='dashboard.php'>Voltar ao Painel</a>.</div>";
            }
        } catch (PDOException $e) {
            $mensagem = "<div class='msg-erro'>Erro ao agendar: " . $e->getMessage() . "</div>";
        }
    } else {
        $mensagem = "<div class='msg-erro'>Preencha todos os campos obrigatórios.</div>";
    }
}

// Configurações do cabeçalho
$pagina_titulo = "Marcar Consulta";
$tipo_usuario = "paciente";
$pagina_ativa = "consultas";

require_once '../includes/cabecalho.php';
?>

<div class="painel-header">
    <div class="painel-header-info">
        <h1>Agendar Consulta</h1>
        <p>Preencha os dados abaixo para agendar um novo atendimento médico.</p>
    </div>
    <a href="dashboard.php" class="btn-hero-sec">
        Voltar ao Dashboard
    </a>
</div>

<div style="display: flex; justify-content: center; width: 100%;">
    <div class="card-formulario" style="max-width: 600px; margin-top: 10px;">
        
        <?php echo $mensagem; ?>

        <form action="marcar_consulta.php" method="POST">

            <div class="form-grupo">
                <label for="id_medico">Médico / Especialidade *</label>
                <select id="id_medico" name="id_medico" required>
                    <option value="">-- Selecione o Médico --</option>
                    <?php foreach ($medicos as $medico): ?>
                        <option value="<?php echo $medico['id_medico']; ?>">
                            <?php echo htmlspecialchars($medico['especialidade'] . " - Dr. " . $medico['nome']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-grupo">
                <label for="data_consulta">Data *</label>
                <input type="date" id="data_consulta" name="data_consulta" min="<?php echo date('Y-m-d'); ?>" required>
            </div>

            <div class="form-grupo">
                <label for="hora_consulta">Horário *</label>
                <input type="time" id="hora_consulta" name="hora_consulta" required>
            </div>

            <div class="form-grupo" style="margin-bottom: 30px;">
                <label for="motivo_consulta">Sintomas / Motivo da Consulta (Opcional)</label>
                <textarea id="motivo_consulta" name="motivo_consulta" rows="4" placeholder="Descreva brevemente o que sente..." style="resize: none;"></textarea>
            </div>

            <button type="submit" class="btn-hero-primario">
                Confirmar Agendamento ✓
            </button>

        </form>
    </div>
</div>

<?php
require_once '../includes/rodape.php';
?>