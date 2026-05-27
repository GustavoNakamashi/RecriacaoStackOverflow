<?php
session_start();
require_once __DIR__ . '/../config/conexao.php';

$id = (int)($_POST['id'] ?? 0);
if ($id && isset($_SESSION['usuario_id'])) {
    $pdo->prepare("DELETE FROM perguntas WHERE id = ? AND usuario_id = ?")->execute([$id, $_SESSION['usuario_id']]);
}
header('Location: ../view/perguntas.php');
exit;