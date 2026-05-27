<?php
session_start();
require_once __DIR__ . '/../config/conexao.php';

if (!isset($_SESSION['usuario_id']) || empty($_POST['conteudo'])) {
    header('Location: ../view/perguntas.php');
    exit;
}

$stmt = $pdo->prepare("INSERT INTO respostas (pergunta_id, usuario_id, conteudo) VALUES (?, ?, ?)");
$stmt->execute([$_POST['pergunta_id'], $_SESSION['usuario_id'], $_POST['conteudo']]);

header("Location: ../view/perguntas.php?action=ver&id=" . $_POST['pergunta_id']);
exit;