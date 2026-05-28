<?php
// view/nova_pergunta.php - Página para criar nova pergunta
require_once __DIR__ . '/../config/conexao2.php';
session_start();

$usuario_logado = isset($_SESSION['usuario_id']);

// Buscar todas as tags disponíveis
$tags = $pdo->query("SELECT * FROM tags ORDER BY nome")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Pergunta - StackOverflow Fatec</title>
    <link rel="stylesheet" href="../css/styleNovapergunta.css">
</head>
<body>

<!-- MENU LATERAL -->
<ul>
    <li><a href="home.php">Home</a></li>
    <li><a href="perguntas.php">Perguntas</a></li>
    <li><a class="active" href="nova_pergunta.php">Nova Pergunta</a></li>
    <li><a href="desafio.php">Desafios</a></li>
    <?php if($usuario_logado): ?>
        <li><a href="perfil.php">Perfil</a></li>
        <li><a href="../processamento/logout.php">Sair</a></li>
    <?php else: ?>
        <li><a href="login.php">Entrar</a></li>
        <li><a href="perfilUsuario.php">Cadastrar</a></li>
    <?php endif; ?>
</ul>

<!-- ÁREA PRINCIPAL -->
<div class="main-content">
    <div class="form-container">
        <h1>Faça sua pergunta</h1>
        <p class="subtitulo">Seja claro e específico para ajudar a comunidade a te ajudar melhor.</p>

        <?php if(isset($_SESSION['erro'])): ?>
            <div class="alert-error"><?= htmlspecialchars($_SESSION['erro']); unset($_SESSION['erro']); ?></div>
        <?php endif; ?>

        <div class="form-card">
            <form method="POST" action="../processamento/salvar_pergunta.php">
                <div class="form-group">
                    <label class="form-label">Título <span class="requerido">*</span></label>
                    <input type="text" name="titulo" class="form-control" 
                           placeholder="Ex: Como ordenar um array em JavaScript?" required>
                    <small>Dê um título objetivo e direto.</small>
                </div>

                <div class="form-group">
                    <label class="form-label">Conteúdo <span class="requerido">*</span></label>
                    <textarea name="conteudo" class="form-control" 
                              placeholder="Descreva sua dúvida em detalhes, incluindo o que você já tentou..." required></textarea>
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
                    <small>Selecione as tags relacionadas ao seu problema.</small>
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn-submit">Publicar Pergunta</button>
                    <a href="perguntas.php" class="btn-cancel">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>