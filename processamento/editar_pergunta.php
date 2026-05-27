<?php
session_start();
require_once __DIR__ . '/../config/conexao.php';

if (!isset($_SESSION['usuario_id']) || empty($_POST['titulo']) || empty($_POST['conteudo'])) {
    header('Location: ../view/perguntas.php');
    exit;
}

$id = $_POST['pergunta_id'];
$pdo->beginTransaction();

$stmt = $pdo->prepare("UPDATE perguntas SET titulo = ?, conteudo = ? WHERE id = ? AND usuario_id = ?");
$stmt->execute([$_POST['titulo'], $_POST['conteudo'], $id, $_SESSION['usuario_id']]);

$pdo->prepare("DELETE FROM pergunta_tags WHERE pergunta_id = ?")->execute([$id]);
if (!empty($_POST['tags'])) {
    $stmt = $pdo->prepare("INSERT INTO pergunta_tags (pergunta_id, tag_id) VALUES (?, ?)");
    foreach ($_POST['tags'] as $tag_id) {
        $stmt->execute([$id, $tag_id]);
    }
}
$pdo->commit();

header("Location: ../view/perguntas.php?action=ver&id=$id");
exit;