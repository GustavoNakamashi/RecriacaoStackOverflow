<?php
// nova_pergunta.php - Página para fazer uma nova pergunta
require_once __DIR__ . '/../processamento/conexao.php';
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

// Busca todas as tags disponíveis
$tags = $pdo->query("SELECT * FROM tags ORDER BY nome")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Pergunta - StackOverflow Fatec</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/stylePerguntas.css">
</head>
<body>

<nav class="navbar">
    <div class="nav-container">
        <div class="nav-logo">
            <a href="home.php">StackOverflow Fatec</a>
        </div>
        <div class="nav-links">
            <a href="home.php">Início</a>
            <a href="perguntas.php">Perguntas</a>
            <a href="nova_pergunta.php" class="active">Perguntar</a>
            <a href="desafio.php">Desafios</a>
            <a href="perfil.php"><?= htmlspecialchars($_SESSION['usuario_nome']) ?></a>
            <a href="../processamento/logout.php">Sair</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="form-pergunta">
        <h1>Faça sua pergunta</h1>
        <p class="subtitulo">Seja claro e específico para ajudar a comunidade a te ajudar melhor.</p>

        <form method="POST" action="../processamento/salvar_pergunta.php">
            <div class="form-group">
                <label class="form-label" for="titulo">Título</label>
                <input type="text" id="titulo" name="titulo" class="form-control" 
                       placeholder="Ex: Como ordenar um array em JavaScript?" required>
                <small style="color: rgb(108, 117, 125);">Dê um título objetivo e direto.</small>
            </div>

            <div class="form-group">
                <label class="form-label" for="conteudo">Conteúdo</label>
                <textarea id="conteudo" name="conteudo" class="form-control" 
                          placeholder="Descreva sua dúvida em detalhes, incluindo o que você já tentou..." rows="8" required></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Tags</label>
                <div class="tags-select">
                    <?php foreach ($tags as $t): ?>
                        <label class="tag-checkbox">
                            <input type="checkbox" name="tags[]" value="<?= $t['id'] ?>">
                            <?= htmlspecialchars($t['nome']) ?>
                        </label>
                    <?php endforeach; ?>
                </div>
                <small style="color: rgb(108, 117, 125);">Selecione pelo menos uma tag relacionada ao seu problema.</small>
            </div>

            <div style="display: flex; gap: 15px; margin-top: 20px;">
                <button type="submit" class="btn btn-primary">Publicar Pergunta</button>
                <a href="perguntas.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<footer class="footer">
    <p>© 2025 StackOverflow Fatec - Trabalho acadêmico</p>
</footer>

</body>
</html>