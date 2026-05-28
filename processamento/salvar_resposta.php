<?php
session_start();
require_once __DIR__ . '/../config/conexao2.php';

// Verificar se os dados foram enviados
if (empty($_POST['conteudo']) || empty($_POST['pergunta_id'])) {
    $_SESSION['erro'] = "A resposta não pode estar vazia.";
    header('Location: ../view/perguntas.php?action=ver&id=' . $_POST['pergunta_id']);
    exit;
}

$pergunta_id = (int)$_POST['pergunta_id'];
$conteudo = trim($_POST['conteudo']);
$autor_nome = trim($_POST['autor_nome'] ?? '');

// Se não informou nome, coloca "Anônimo"
if (empty($autor_nome)) {
    $autor_nome = 'Anônimo';
}

try {
    // Verificar se o usuário está logado
    if (isset($_SESSION['usuario_id'])) {
        // Usuário logado: salva com usuario_id e autor_nome
        $stmt = $pdo->prepare("INSERT INTO respostas (pergunta_id, usuario_id, autor_nome, conteudo) VALUES (?, ?, ?, ?)");
        $stmt->execute([$pergunta_id, $_SESSION['usuario_id'], $autor_nome, $conteudo]);
    } else {
        // Usuário não logado: salva sem usuario_id (NULL)
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