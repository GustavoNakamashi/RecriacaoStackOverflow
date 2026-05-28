<?php
session_start();
require_once __DIR__ . '/../config/conexao2.php';
 
// Verificar se os dados foram enviados
if (empty($_POST['titulo']) || empty($_POST['conteudo'])) {
    $_SESSION['erro'] = "Preencha todos os campos obrigatórios.";
    header('Location: ../view/perguntas.php?action=nova');
    exit;
}

// Definir o ID do usuário
if (isset($_SESSION['usuario_id'])) {
    $usuario_id = $_SESSION['usuario_id'];
} else {
    // Buscar ou criar usuário anônimo
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE nome = 'Anônimo' LIMIT 1");
    $stmt->execute();
    $anonimo = $stmt->fetch();
    if ($anonimo) {
        $usuario_id = $anonimo['id'];
    } else {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES ('Anônimo', 'anonimo@temp.com', MD5('temp'))");
        $stmt->execute();
        $usuario_id = $pdo->lastInsertId();
    }
}

$titulo = trim($_POST['titulo']);
$conteudo = trim($_POST['conteudo']);
$tags = isset($_POST['tags']) ? $_POST['tags'] : [];

try {
    $pdo->beginTransaction();
    
    // Inserir pergunta
    $stmt = $pdo->prepare("INSERT INTO perguntas (titulo, conteudo, usuario_id) VALUES (?, ?, ?)");
    $stmt->execute([$titulo, $conteudo, $usuario_id]);
    $pergunta_id = $pdo->lastInsertId();
    
    // Inserir tags relacionadas
    if (!empty($tags)) {
        $stmt = $pdo->prepare("INSERT INTO pergunta_tags (pergunta_id, tag_id) VALUES (?, ?)");
        foreach ($tags as $tag_id) {
            $stmt->execute([$pergunta_id, $tag_id]);
        }
    }
    
    $pdo->commit();
    
    $_SESSION['mensagem'] = "Pergunta publicada com sucesso!";
    header("Location: ../view/perguntas.php?action=ver&id=$pergunta_id");
    exit;
    
} catch(Exception $e) {
    $pdo->rollBack();
    $_SESSION['erro'] = "Erro ao publicar: " . $e->getMessage();
    header('Location: ../view/perguntas.php?action=nova');
    exit;
}
?>
