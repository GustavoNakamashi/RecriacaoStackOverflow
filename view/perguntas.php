<?php
require_once __DIR__ . '/../config/conexao2.php';
session_start();

$action = $_GET['action'] ?? 'listar';
$usuario_logado = isset($_SESSION['usuario_id']);
$id = (int)($_GET['id'] ?? 0);

// LISTAR PERGUNTAS
if ($action == 'listar') {
    $busca = $_GET['busca'] ?? '';
    $tag = $_GET['tag'] ?? '';
    $ordenar = $_GET['ordenar'] ?? 'recentes';

    $sql = "SELECT p.*, u.nome as autor,
            (SELECT COUNT(*) FROM respostas WHERE pergunta_id = p.id) as total_respostas
            FROM perguntas p 
            JOIN usuarios u ON p.usuario_id = u.id WHERE 1=1";
    $params = [];
    if ($busca) {
        $sql .= " AND (p.titulo LIKE ? OR p.conteudo LIKE ?)";
        $params[] = "%$busca%";
        $params[] = "%$busca%";
    }
    if ($tag) {
        $sql .= " AND EXISTS (SELECT 1 FROM pergunta_tags pt JOIN tags t ON pt.tag_id = t.id 
                  WHERE pt.pergunta_id = p.id AND t.nome = ?)";
        $params[] = $tag;
    }
    switch ($ordenar) {
        case 'antigas': $sql .= " ORDER BY p.data_criacao ASC"; break;
        case 'respondidas': $sql .= " ORDER BY total_respostas DESC"; break;
        default: $sql .= " ORDER BY p.data_criacao DESC";
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $perguntas = $stmt->fetchAll();

    $tags = $pdo->query("SELECT * FROM tags ORDER BY nome")->fetchAll();
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Perguntas - StackOverflow Fatec</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../css/stylePerguntas.css">
    </head>
    <body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo"><a href="home.php">StackOverflow Fatec</a></div>
            <div class="nav-links">
                <a href="home.php">Início</a>
                <a href="perguntas.php?action=nova">Perguntar</a>
                <a href="desafio.php">Desafios</a>
                <?php if ($usuario_logado): ?>
                    <a href="perfil.php"><?= htmlspecialchars($_SESSION['usuario_nome']) ?></a>
                    <a href="../processamento/logout.php">Sair</a>
                <?php else: ?>
                    <a href="login.php">Entrar</a>
                    <a href="cadastro.php">Cadastrar</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <div class="container">
        <h1>Todas as Perguntas</h1>
        <a href="nova_pergunta.php" class="btn btn-primary">Nova Pergunta</a>
        <div class="filtros">
            <form method="POST" class="filtros-form">
                <input type="hidden" name="action" value="listar">
                <input type="text" name="busca" placeholder="Buscar..." value="<?= htmlspecialchars($busca) ?>">
                <select name="tag">
                    <option value="">Todas tags</option>
                    <?php foreach ($tags as $t): ?>
                        <option value="<?= $t['nome'] ?>" <?= $tag == $t['nome'] ? 'selected' : '' ?>><?= $t['nome'] ?></option>
                    <?php endforeach; ?>
                </select>
                <select name="ordenar">
                    <option value="recentes" <?= $ordenar == 'recentes' ? 'selected' : '' ?>>Mais recentes</option>
                    <option value="antigas" <?= $ordenar == 'antigas' ? 'selected' : '' ?>>Mais antigas</option>
                    <option value="respondidas" <?= $ordenar == 'respondidas' ? 'selected' : '' ?>>Mais respondidas</option>
                </select>
                <button type="submit" class="btn btn-secondary">Filtrar</button>
            </form>
        </div>
        <?php foreach ($perguntas as $p): ?>
            <div class="card">
                <a href="?action=ver&id=<?= $p['id'] ?>" class="pergunta-titulo"><?= htmlspecialchars($p['titulo']) ?></a>
                <div class="pergunta-meta">
                    <?= $p['total_respostas'] ?> respostas | 
                    <?= $p['visualizacoes'] ?> visualizações | 
                    por <?= htmlspecialchars($p['autor']) ?> | 
                    <?= date('d/m/Y', strtotime($p['data_criacao'])) ?>
                </div>
                <div><?= substr(htmlspecialchars($p['conteudo']), 0, 150) ?>...</div>
            </div>
        <?php endforeach; ?>
    </div>
    <footer class="footer"><p>© 2025 StackOverflow Fatec - Trabalho acadêmico</p></footer>
    </body>
    </html>
    <?php
} // FIM DO listar

// NOVA PERGUNTA
elseif ($action == 'nova') {
    if (!$usuario_logado) {
        header('Location: login.php');
        exit;
    }
    $tags = $pdo->query("SELECT * FROM tags ORDER BY nome")->fetchAll();
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Nova Pergunta</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
    <nav class="navbar"><div class="nav-container"><div class="nav-logo"><a href="home.php">StackOverflow Fatec</a></div><div class="nav-links"><a href="home.php">Início</a><a href="perguntas.php">Perguntas</a><a href="perguntas.php?action=nova">Perguntar</a><a href="desafio.php">Desafios</a><?php if ($usuario_logado): ?><a href="perfil.php"><?= $_SESSION['usuario_nome'] ?></a><a href="../processamento/logout.php">Sair</a><?php else: ?><a href="login.php">Entrar</a><a href="cadastro.php">Cadastrar</a><?php endif; ?></div></div></nav>
    <div class="container">
        <h1>Fazer Pergunta</h1>
        <div class="form-pergunta">
            <form method="POST" action="../processamento/salvar_pergunta.php">
                <div class="form-group"><label class="form-label">Título</label><input type="text" name="titulo" class="form-control" required></div>
                <div class="form-group"><label class="form-label">Conteúdo</label><textarea name="conteudo" class="form-control" required></textarea></div>
                <div class="form-group"><label class="form-label">Tags</label><div class="tags-select">
                    <?php foreach ($tags as $t): ?>
                        <label class="tag-checkbox"><input type="checkbox" name="tags[]" value="<?= $t['id'] ?>"> <?= $t['nome'] ?></label>
                    <?php endforeach; ?>
                </div></div>
                <button type="submit" class="btn btn-primary">Publicar</button>
                <a href="perguntas.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
    <footer class="footer"><p>© 2025 StackOverflow Fatec</p></footer>
    </body>
    </html>
    <?php
} // FIM DO nova

// VER PERGUNTA (com respostas)
elseif ($action == 'ver' && $id) {
    // Incrementar visualizações
    $pdo->prepare("UPDATE perguntas SET visualizacoes = visualizacoes + 1 WHERE id = ?")->execute([$id]);

    $stmt = $pdo->prepare("SELECT p.*, u.nome as autor FROM perguntas p JOIN usuarios u ON p.usuario_id = u.id WHERE p.id = ?");
    $stmt->execute([$id]);
    $pergunta = $stmt->fetch();
    if (!$pergunta) die("Pergunta não encontrada");

    $stmt = $pdo->prepare("SELECT t.nome FROM tags t JOIN pergunta_tags pt ON t.id = pt.tag_id WHERE pt.pergunta_id = ?");
    $stmt->execute([$id]);
    $tags = $stmt->fetchAll();

    $stmt = $pdo->prepare("SELECT r.*, u.nome as autor FROM respostas r LEFT JOIN usuarios u ON r.usuario_id = u.id WHERE r.pergunta_id = ? ORDER BY r.data_criacao ASC");
    $stmt->execute([$id]);
    $respostas = $stmt->fetchAll();
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title><?= htmlspecialchars($pergunta['titulo']) ?></title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
    <nav class="navbar"><div class="nav-container"><div class="nav-logo"><a href="home.php">StackOverflow Fatec</a></div><div class="nav-links"><a href="home.php">Início</a><a href="perguntas.php">Perguntas</a><a href="perguntas.php?action=nova">Perguntar</a><a href="desafio.php">Desafios</a><?php if ($usuario_logado): ?><a href="perfil.php"><?= $_SESSION['usuario_nome'] ?></a><a href="../processamento/logout.php">Sair</a><?php else: ?><a href="login.php">Entrar</a><a href="cadastro.php">Cadastrar</a><?php endif; ?></div></div></nav>
    <div class="container">
        <div class="card">
            <h1><?= htmlspecialchars($pergunta['titulo']) ?></h1>
            <div class="pergunta-meta">Por <?= htmlspecialchars($pergunta['autor']) ?> | <?= $pergunta['visualizacoes'] ?> visualizações</div>
            <div class="tags"><?php foreach ($tags as $t): ?><span class="tag"><?= $t['nome'] ?></span><?php endforeach; ?></div>
            <div class="pergunta-conteudo"><?= nl2br(htmlspecialchars($pergunta['conteudo'])) ?></div>
            <?php if ($usuario_logado && $_SESSION['usuario_id'] == $pergunta['usuario_id']): ?>
                <div style="margin-top:20px">
                    <a href="?action=editar&id=<?= $id ?>" class="btn btn-secondary">Editar</a>
                    <a href="../processamento/deletar_pergunta.php?id=<?= $id ?>" class="btn btn-danger" onclick="return confirm('Deletar?')">Deletar</a>
                </div>
            <?php endif; ?>
        </div>
        <h2>Respostas</h2>
        <?php foreach ($respostas as $r): ?>
            <div class="resposta <?= $r['is_ia'] ? 'resposta-ia' : '' ?>">
                <?php if ($r['is_ia']): ?><div class="badge-ia">Resposta da IA</div><?php else: ?><strong><?= htmlspecialchars($r['autor'] ?? 'Usuário') ?></strong><?php endif; ?>
                <div><?= nl2br(htmlspecialchars($r['conteudo'])) ?></div>
                <div class="pergunta-meta"><?= date('d/m/Y H:i', strtotime($r['data_criacao'])) ?></div>
            </div>
        <?php endforeach; ?>
        <?php if ($usuario_logado): ?>
            <div class="form-resposta">
                <h3>Sua Resposta</h3>
                <form method="POST" action="../processamento/salvar_resposta.php">
                    <input type="hidden" name="pergunta_id" value="<?= $id ?>">
                    <textarea name="conteudo" class="form-control" rows="5" required></textarea>
                    <button type="submit" class="btn btn-primary">Responder</button>
                </form>
            </div>
        <?php else: ?>
            <div class="alert-info">Faça <a href="login.php">login</a> para responder</div>
        <?php endif; ?>
    </div>
    <footer class="footer"><p>© 2025 StackOverflow Fatec</p></footer>
    </body>
    </html>
    <?php
} // FIM DO ver

// EDITAR PERGUNTA
elseif ($action == 'editar' && $id) {
    if (!$usuario_logado) {
        header('Location: login.php');
        exit;
    }
    $stmt = $pdo->prepare("SELECT * FROM perguntas WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$id, $_SESSION['usuario_id']]);
    $pergunta = $stmt->fetch();
    if (!$pergunta) {
        header('Location: perguntas.php');
        exit;
    }
    $tagsDisponiveis = $pdo->query("SELECT * FROM tags ORDER BY nome")->fetchAll();
    $stmt = $pdo->prepare("SELECT tag_id FROM pergunta_tags WHERE pergunta_id = ?");
    $stmt->execute([$id]);
    $tagsSelecionadas = $stmt->fetchAll(PDO::FETCH_COLUMN);
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Editar Pergunta</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
    <nav class="navbar"><!-- navbar --></nav>
    <div class="container">
        <h1>Editar Pergunta</h1>
        <div class="form-pergunta">
            <form method="POST" action="../processamento/editar_pergunta.php">
                <input type="hidden" name="pergunta_id" value="<?= $id ?>">
                <div class="form-group"><label class="form-label">Título</label><input type="text" name="titulo" value="<?= htmlspecialchars($pergunta['titulo']) ?>" class="form-control" required></div>
                <div class="form-group"><label class="form-label">Conteúdo</label><textarea name="conteudo" class="form-control" required><?= htmlspecialchars($pergunta['conteudo']) ?></textarea></div>
                <div class="form-group"><label class="form-label">Tags</label><div class="tags-select">
                    <?php foreach ($tagsDisponiveis as $t): ?>
                        <label class="tag-checkbox"><input type="checkbox" name="tags[]" value="<?= $t['id'] ?>" <?= in_array($t['id'], $tagsSelecionadas) ? 'checked' : '' ?>><?= $t['nome'] ?></label>
                    <?php endforeach; ?>
                </div></div>
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="?action=ver&id=<?= $id ?>" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
    <footer class="footer"><p>© 2025 StackOverflow Fatec</p></footer>
    </body>
    </html>
    <?php
} // FIM DO editar

// BUSCAR
elseif ($action == 'buscar') {
    $termo = $_GET['q'] ?? '';
    $resultados = [];
    if ($termo) {
        $stmt = $pdo->prepare("SELECT p.*, u.nome as autor FROM perguntas p JOIN usuarios u ON p.usuario_id = u.id WHERE p.titulo LIKE ? OR p.conteudo LIKE ? ORDER BY p.data_criacao DESC");
        $stmt->execute(["%$termo%", "%$termo%"]);
        $resultados = $stmt->fetchAll();
    }
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Buscar - StackOverflow Fatec</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
    <nav class="navbar"><!-- navbar --></nav>
    <div class="container">
        <h1>Buscar Perguntas</h1>
        <div class="filtros">
            <form method="GET" class="filtros-form">
                <input type="hidden" name="action" value="buscar">
                <input type="text" name="q" placeholder="Digite sua busca..." value="<?= htmlspecialchars($termo) ?>">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>
        </div>
        <?php if ($termo): ?>
            <h2>Resultados para "<?= htmlspecialchars($termo) ?>" (<?= count($resultados) ?>)</h2>
            <?php foreach ($resultados as $p): ?>
                <div class="card">
                    <a href="?action=ver&id=<?= $p['id'] ?>" class="pergunta-titulo"><?= htmlspecialchars($p['titulo']) ?></a>
                    <div class="pergunta-meta">por <?= htmlspecialchars($p['autor']) ?> | <?= date('d/m/Y', strtotime($p['data_criacao'])) ?></div>
                    <div><?= substr(htmlspecialchars($p['conteudo']), 0, 150) ?>...</div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert-info">Digite um termo para buscar</div>
        <?php endif; ?>
    </div>
    <footer class="footer"><p>© 2025 StackOverflow Fatec</p></footer>
    </body>
    </html>
    <?php
} // FIM DO buscar

// Se nenhuma ação corresponder, apenas mostra a listagem
else {
    header('Location: perguntas.php?action=listar');
    exit;
}
?>