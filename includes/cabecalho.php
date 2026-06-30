<?php


$titulo    = isset($pagina_titulo) ? htmlspecialchars($pagina_titulo) . ' — HGH' : 'Hospital Geral do Huambo';
$tipo      = isset($tipo_usuario)  ? $tipo_usuario : 'paciente';
$ativa     = isset($pagina_ativa)  ? $pagina_ativa : '';

if ($tipo === 'medico') {
    $nome_user = isset($_SESSION['nome_medico']) ? htmlspecialchars($_SESSION['nome_medico']) : 'Médico';
} else {
    $nome_user = isset($_SESSION['nome_paciente']) ? htmlspecialchars($_SESSION['nome_paciente']) : 'Paciente';
}

// Define os links de navegação consoante o tipo de utilizador
$links_paciente = [
    'dashboard'  => ['url' => 'dashboard.php',       'label' => 'Início',       'icone' => '🏠'],
    'consultas'  => ['url' => 'marcar_consulta.php',  'label' => 'Marcar Consulta', 'icone' => '📅'],
    'historico'  => ['url' => 'historico.php',        'label' => 'Histórico',    'icone' => '📋'],
    'perfil'     => ['url' => 'perfil.php',           'label' => 'Meu Perfil',   'icone' => '👤'],
];

$links_medico = [
    'dashboard'  => ['url' => 'dashboard.php',   'label' => 'Início',       'icone' => '🏠'],
    'agenda'     => ['url' => 'agenda.php',       'label' => 'Agenda',       'icone' => '📅'],
    'resultado'  => ['url' => 'resultado.php',    'label' => 'Resultados',   'icone' => '🩺'],
    'perfil'     => ['url' => 'perfil.php',       'label' => 'Meu Perfil',   'icone' => '👨‍⚕️'],
];

$links = ($tipo === 'medico') ? $links_medico : $links_paciente;
$logout_url = ($tipo === 'medico') ? '../medicos/logout.php' : '../paciente/logout.php';
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>
    <link rel="stylesheet" href="../assets/css/estilo.css">
</head>

<body>

    <div class="pagina">

        <!-- ── Cabeçalho Principal ── -->
        <header class="cabecalho">
            <div class="cabecalho-inner">

                <!-- Logo -->
                <a href="../index.php" class="logo">
                    <div class="logo-icone">🏥</div>
                    <div class="logo-info">
                        <strong>Hospital Geral do Huambo</strong>
                        <span>Sistema de Consultas</span>
                    </div>
                </a>

                <!-- Navegação -->
                <nav class="nav-cabecalho" aria-label="Navegação principal">
                    <?php foreach ($links as $chave => $link): ?>
                        <a href="<?php echo $link['url']; ?>"
                            class="<?php echo ($ativa === $chave) ? 'ativo' : ''; ?>"
                            title="<?php echo $link['label']; ?>">
                            <span aria-hidden="true"><?php echo $link['icone']; ?></span>
                            <?php echo $link['label']; ?>
                        </a>
                    <?php endforeach; ?>

                    <!-- Separador + Sair -->
                    <a href="<?php echo $logout_url; ?>" class="btn-sair" title="Terminar sessão">
                        ⬡ Sair
                    </a>
                </nav>

            </div>
        </header>

        <!-- O conteúdo da página vai aqui (fechado no rodape.php) -->
        <main>