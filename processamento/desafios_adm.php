<?php
session_start();
require_once __DIR__ . '/../config/conexao2.php';
if ($_SESSION['usuario_id'] != 1) { header('Location: ../view/home.php'); exit; }

if ($_POST['acao'] == 'criar') {
    $stmt = $pdo->prepare("INSERT INTO desafios (titulo, descricao, dificuldade) VALUES (?, ?, ?)");
    $stmt->execute([$_POST['titulo'], $_POST['descricao'], $_POST['dificuldade']]);
} elseif ($_POST['acao'] == 'deletar') {
    $pdo->prepare("DELETE FROM desafios WHERE id = ?")->execute([$_POST['id']]);
}
header('Location: ../view/desafio.php');
exit;