<?php
// 1. Inicia a sessão para ganhar acesso às variáveis ativas que queremos destruir
session_start();

// 2. Remove todas as variáveis guardadas na sessão ($_SESSION['id_paciente'], etc.)
session_unset();

// 3. Destrói completamente a sessão ativa no servidor
session_destroy();

// 4. Redireciona o utilizador imediatamente para o ecrã de login
header("Location: login.php");
exit();
