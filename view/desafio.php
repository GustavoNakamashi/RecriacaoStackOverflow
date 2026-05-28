<?php
// view/desafio.php - Desafios com respostas (qualquer pessoa pode responder)
require_once __DIR__ . '/../config/conexao2.php';
session_start();

$is_admin = (isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] == 1);

// Processar envio de solução (agora sem exigir login)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar_solucao'])) {
    $desafio_id = (int)$_POST['desafio_id'];
    $solucao = trim($_POST['solucao']);
    $linguagem = trim($_POST['linguagem']);
    $autor_nome = trim($_POST['autor_nome']);
    if (empty($autor_nome)) {
        $autor_nome = 'Anônimo';
    }
    if (!empty($solucao)) {
        $stmt = $pdo->prepare("INSERT INTO respostas_desafios (desafio_id, usuario_id, autor_nome, solucao, linguagem) VALUES (?, NULL, ?, ?, ?)");
        $stmt->execute([$desafio_id, $autor_nome, $solucao, $linguagem]);
        $_SESSION['mensagem'] = "Solução enviada com sucesso!";
    } else {
        $_SESSION['erro'] = "A solução não pode estar vazia.";
    }
    header("Location: desafio.php#desafio-$desafio_id");
    exit;
}

// Buscar desafios
$sql = "SELECT * FROM desafios ORDER BY 
        CASE dificuldade 
            WHEN 'Fácil' THEN 1 
            WHEN 'Médio' THEN 2 
            WHEN 'Difícil' THEN 3 
        END, data_publicacao DESC";
$desafios = $pdo->query($sql)->fetchAll();

// Buscar soluções (agora usando autor_nome em vez de u.nome)
$solucoes_por_desafio = [];
foreach ($desafios as $d) {
    $stmt = $pdo->prepare("SELECT id, usuario_id, autor_nome, solucao, linguagem, data_envio 
                           FROM respostas_desafios 
                           WHERE desafio_id = ? 
                           ORDER BY data_envio DESC");
    $stmt->execute([$d['id']]);
    $solucoes_por_desafio[$d['id']] = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Desafios - StackOverflow Fatec</title>
    <link rel="stylesheet" href="../css/styleDesafio.css">
</head>
<body>

<ul>
    <li><a href="home.php">Home</a></li>
    <li><a href="perguntas.php">Perguntas</a></li>
    <li><a href="nova_pergunta.php">Nova Pergunta</a></li>
    <li><a a class="active" href="desafio.php">Desafios</a></li>
    <?php if(isset($_SESSION['usuario_id'])): ?>
        <li><a href="perfil.php">Perfil</a></li>
        <li><a href="../processamento/logout.php">Sair</a></li>
    <?php else: ?>
        <li><a href="cadUsuario.php">Cadastrar</a></li>
        <li><a href="perfilUsuario.php">Perfil</a></li>
    <?php endif; ?>
</ul>

<div style="margin-left: 20%; padding: 20px; background: #f5f5f5; min-height: 100vh;">
    <div style="max-width: 1000px; margin: 0 auto;">
        <h1 style="color: #333;">Desafios de Programação</h1>
        <p style="color: #666; margin-bottom: 30px;">Resolva os desafios e compartilhe sua solução</p>

        <?php if(isset($_SESSION['mensagem'])): ?>
            <div class="alert-success"><?= $_SESSION['mensagem']; unset($_SESSION['mensagem']); ?></div>
        <?php endif; ?>
        <?php if(isset($_SESSION['erro'])): ?>
            <div class="alert-error"><?= $_SESSION['erro']; unset($_SESSION['erro']); ?></div>
        <?php endif; ?>

        <?php if($is_admin): ?>
            <div class="admin-panel">
                <h3>Painel do Administrador</h3>
                <form method="POST" action="../processamento/desafios_adm.php">
                    <input type="hidden" name="acao" value="criar">
                    <input type="text" name="titulo" placeholder="Título do desafio" required style="width:100%; margin-bottom:8px;">
                    <textarea name="descricao" placeholder="Descrição do desafio" rows="3" style="width:100%; margin-bottom:8px;"></textarea>
                    <select name="dificuldade" style="margin-bottom:8px;">
                        <option value="Fácil">Fácil</option>
                        <option value="Médio">Médio</option>
                        <option value="Difícil">Difícil</option>
                    </select>
                    <button type="submit" class="btn-admin">Criar Desafio</button>
                </form>
            </div>
        <?php endif; ?>

        <?php foreach ($desafios as $desafio): ?>
            <div class="desafio-card" id="desafio-<?= $desafio['id'] ?>">
                <div class="dificuldade dificuldade-<?= $desafio['dificuldade'] ?>">
                    <?= htmlspecialchars($desafio['dificuldade']) ?>
                </div>
                <div class="desafio-titulo"><?= htmlspecialchars($desafio['titulo']) ?></div>
                <div class="desafio-descricao"><?= nl2br(htmlspecialchars($desafio['descricao'])) ?></div>
                <div class="desafio-data">Publicado em: <?= date('d/m/Y', strtotime($desafio['data_publicacao'])) ?></div>

                <!-- Exibir soluções já enviadas -->
                <?php if (!empty($solucoes_por_desafio[$desafio['id']])): ?>
                    <h4 style="margin-top: 20px;">Soluções enviadas:</h4>
                    <?php foreach ($solucoes_por_desafio[$desafio['id']] as $sol): ?>
                        <div class="solucao">
                            <div>
                                <span class="solucao-autor"><?= htmlspecialchars($sol['autor_nome'] ?? 'Anônimo') ?></span>
                                <span class="solucao-data"><?= date('d/m/Y H:i', strtotime($sol['data_envio'])) ?></span>
                                <?php if (!empty($sol['linguagem'])): ?>
                                    <span class="linguagem-badge"><?= htmlspecialchars($sol['linguagem']) ?></span>
                                <?php endif; ?>
                            </div>
                            <pre style="white-space: pre-wrap; margin-top: 8px;"><?= htmlspecialchars($sol['solucao']) ?></pre>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color:#6c757d; margin-top:20px;"><em>Nenhuma solução ainda. Seja o primeiro!</em></p>
                <?php endif; ?>

                <!-- Formulário para enviar solução (agora qualquer visitante) -->
                <div class="form-solucao">
                    <h4>Envie sua solução</h4>
                    <form method="POST" action="">
                        <input type="hidden" name="desafio_id" value="<?= $desafio['id'] ?>">
                        <label>Seu nome (opcional):</label>
                        <input type="text" name="autor_nome" placeholder="Ex: João Silva" style="width: 100%; max-width: 300px;">
                        <label>Linguagem (opcional):</label>
                        <input type="text" name="linguagem" placeholder="Ex: PHP, Python, JavaScript">
                        <textarea name="solucao" rows="4" placeholder="Digite sua solução aqui (código ou explicação)..." required></textarea>
                        <button type="submit" name="enviar_solucao" class="btn-enviar">Enviar Solução</button>
                    </form>
                </div>

                <?php if ($is_admin): ?>
                    <form method="POST" action="../processamento/desafios_adm.php" style="margin-top: 15px;">
                        <input type="hidden" name="acao" value="deletar">
                        <input type="hidden" name="id" value="<?= $desafio['id'] ?>">
                        <button type="submit" class="btn-deletar" onclick="return confirm('Deletar este desafio?')">Deletar Desafio</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>