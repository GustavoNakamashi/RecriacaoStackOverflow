<?php
session_start();
require_once __DIR__ . '/../config/conexao.php';

if (!isset($_SESSION['usuario_id']) || empty($_POST['titulo']) || empty($_POST['conteudo'])) {
    header('Location: ../view/perguntas.php');
    exit;
}

$pdo->beginTransaction();
$stmt = $pdo->prepare("INSERT INTO perguntas (titulo, conteudo, usuario_id) VALUES (?, ?, ?)");
$stmt->execute([$_POST['titulo'], $_POST['conteudo'], $_SESSION['usuario_id']]);
$id = $pdo->lastInsertId();

if (!empty($_POST['tags'])) {
    $stmt = $pdo->prepare("INSERT INTO pergunta_tags (pergunta_id, tag_id) VALUES (?, ?)");
    foreach ($_POST['tags'] as $tag_id) {
        $stmt->execute([$id, $tag_id]);
    }
}
$pdo->commit();

header("Location: ../view/perguntas.php?action=ver&id=$id");
exit;