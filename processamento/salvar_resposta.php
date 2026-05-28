<?php
session_start();
require_once __DIR__ . '/../config/conexao2.php';

if (empty($_POST['conteudo']) || empty($_POST['pergunta_id'])) {
    $_SESSION['erro'] = "A resposta nao pode estar vazia.";
    header('Location: ../view/perguntas.php?action=ver&id=' . $_POST['pergunta_id']);
    exit;
}

$pergunta_id = (int)$_POST['pergunta_id'];
$conteudo = trim($_POST['conteudo']);
$autor_nome = trim($_POST['autor_nome'] ?? '');

if (empty($autor_nome)) {
    $autor_nome = 'Anonimo';
}

try {
    if (isset($_SESSION['usuario_id'])) {
        $stmt = $pdo->prepare("INSERT INTO respostas (pergunta_id, usuario_id, autor_nome, conteudo) VALUES (?, ?, ?, ?)");
        $stmt->execute([$pergunta_id, $_SESSION['usuario_id'], $autor_nome, $conteudo]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO respostas (pergunta_id, usuario_id, autor_nome, conteudo) VALUES (?, NULL, ?, ?)");
        $stmt->execute([$pergunta_id, $autor_nome, $conteudo]);
    }
    
    $_SESSION['mensagem'] = "Resposta enviada com sucesso!";
    header("Location: ../view/perguntas.php?action=ver&id=$pergunta_id");
    exit;
    
} catch(Exception $e) {
    $_SESSION['erro'] = "Erro ao enviar resposta: " . $e->getMessage();
    header("Location: ../view/perguntas.php?action=ver&id=$pergunta_id");
    exit;
}
?>