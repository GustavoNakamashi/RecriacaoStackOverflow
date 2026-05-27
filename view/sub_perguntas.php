<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StackOverflow Fatec - Perguntas</title>
    <link href="../css/stylePerguntas.css" rel="stylesheet">
</head>
<body>

<ul>
    <li><a href="index.php">Home</a></li>
    <li><a class="active" href="perguntas.php">Todas Perguntas</a></li>
    <li><a href="nova_pergunta.php">Nova Pergunta</a></li>
    <li><a href="buscar.php">Buscar</a></li>
    <li><a href="desafio.php">Desafios</a></li>
    <li><a href="perfilUsuario.php">Perfil</a></li>
</ul>

<div class="conteudo-principal">
    <div class="container">
        <h1>Todas as Perguntas</h1>
        <p class="subtitulo">Explore as perguntas da comunidade e contribua com seu conhecimento!</p>
        
        <a href="nova_pergunta.php" class="btn-principal">+ Fazer Pergunta</a>
        
        <?php
        session_start();
        
        // Exibir mensagens de sessão
        if(isset($_SESSION['mensagem'])) {
            echo '<div class="mensagem-sucesso">' . $_SESSION['mensagem'] . '</div>';
            unset($_SESSION['mensagem']);
        }
        
        if(isset($_SESSION['erro'])) {
            echo '<div class="mensagem-erro">' . $_SESSION['erro'] . '</div>';
            unset($_SESSION['erro']);
        }
        
        // Incluir conexão com banco de dados (caminho correto saindo da pasta view)
        require_once '../config/conexao.php';
        
        // Verificar se é admin (usuário com id = 1)
        $is_admin = isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] == 1;
        
        // Configuração de paginação
        $itens_por_pagina = 10;
        $pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $offset = ($pagina_atual - 1) * $itens_por_pagina;
        
        // Filtros
        $busca = isset($_GET['busca']) ? $_GET['busca'] : '';
        $tag_filtro = isset($_GET['tag']) ? $_GET['tag'] : '';
        $ordenar = isset($_GET['ordenar']) ? $_GET['ordenar'] : 'recentes';
        
        // Construir consulta SQL base
        $sql_base = "FROM perguntas p 
                     JOIN usuarios u ON p.usuario_id = u.id 
                     LEFT JOIN pergunta_tags pt ON p.id = pt.pergunta_id
                     LEFT JOIN tags t ON pt.tag_id = t.id
                     WHERE 1=1";
        
        $params = [];
        
        // Filtro por busca
        if(!empty($busca)) {
            $sql_base .= " AND (p.titulo LIKE ? OR p.conteudo LIKE ?)";
            $params[] = "%$busca%";
            $params[] = "%$busca%";
        }
        
        // Filtro por tag
        if(!empty($tag_filtro)) {
            $sql_base .= " AND t.nome = ?";
            $params[] = $tag_filtro;
        }
        
        // Ordenação
        switch($ordenar) {
            case 'antigas':
                $order_by = "ORDER BY p.data_criacao ASC";
                break;
            case 'respondidas':
                $order_by = "ORDER BY (SELECT COUNT(*) FROM respostas WHERE pergunta_id = p.id) DESC";
                break;
            case 'visualizadas':
                $order_by = "ORDER BY p.visualizacoes DESC";
                break;
            default:
                $order_by = "ORDER BY p.data_criacao DESC";
        }
        
        // Contar total de registros
        $sql_count = "SELECT COUNT(DISTINCT p.id) as total $sql_base";
        $stmt_count = $pdo->prepare($sql_count);
        $stmt_count->execute($params);
        $total_registros = $stmt_count->fetch()['total'];
        $total_paginas = ceil($total_registros / $itens_por_pagina);
        
        // Consultar perguntas
        $sql = "SELECT DISTINCT p.*, u.nome as autor_nome,
                (SELECT COUNT(*) FROM respostas WHERE pergunta_id = p.id) as total_respostas
                $sql_base
                GROUP BY p.id
                $order_by
                LIMIT ? OFFSET ?";
        
        $params[] = $itens_por_pagina;
        $params[] = $offset;
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $perguntas = $stmt->fetchAll();
        ?>
        
        <!-- Filtros -->
        <div class="filtros">
            <form method="GET" action="perguntas.php">
                <input type="text" name="busca" placeholder="Buscar perguntas..." 
                       value="<?php echo htmlspecialchars($busca); ?>">
                
                <select name="tag">
                    <option value="">Todas as tags</option>
                    <?php
                    $stmt_tags = $pdo->query("SELECT DISTINCT nome FROM tags ORDER BY nome");
                    $todas_tags = $stmt_tags->fetchAll();
                    foreach($todas_tags as $tag): ?>
                        <option value="<?php echo $tag['nome']; ?>" 
                            <?php echo $tag_filtro == $tag['nome'] ? 'selected' : ''; ?>>
                            <?php echo $tag['nome']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <select name="ordenar">
                    <option value="recentes" <?php echo $ordenar == 'recentes' ? 'selected' : ''; ?>>Mais recentes</option>
                    <option value="antigas" <?php echo $ordenar == 'antigas' ? 'selected' : ''; ?>>Mais antigas</option>
                    <option value="respondidas" <?php echo $ordenar == 'respondidas' ? 'selected' : ''; ?>>Mais respondidas</option>
                    <option value="visualizadas" <?php echo $ordenar == 'visualizadas' ? 'selected' : ''; ?>>Mais visualizadas</option>
                </select>
                
                <button type="submit" class="btn-secundario">Filtrar</button>
            </form>
        </div>
        
        <!-- Resultados -->
        <?php if(count($perguntas) > 0): ?>
            <h2>Resultados: <?php echo $total_registros; ?> pergunta(s)</h2>
            
            <?php foreach($perguntas as $pergunta): ?>
                <div class="pergunta-item">
                    <a href="ver_pergunta.php?id=<?php echo $pergunta['id']; ?>" class="pergunta-titulo">
                        <?php echo htmlspecialchars($pergunta['titulo']); ?>
                    </a>
                    
                    <div class="pergunta-conteudo">
                        <?php echo substr(htmlspecialchars($pergunta['conteudo']), 0, 200); ?>...
                    </div>
                    
                    <div class="pergunta-meta">
                        <span> <?php echo $pergunta['total_respostas']; ?> respostas</span>
                        <span> <?php echo $pergunta['visualizacoes']; ?> visualizações</span>
                        <span> <?php echo htmlspecialchars($pergunta['autor_nome']); ?></span>
                        <span> <?php echo date('d/m/Y H:i', strtotime($pergunta['data_criacao'])); ?></span>
                    </div>
                    
                    <!-- Tags da pergunta -->
                    <?php
                    $sql_tags = "SELECT t.id, t.nome FROM tags t 
                                JOIN pergunta_tags pt ON t.id = pt.tag_id 
                                WHERE pt.pergunta_id = ?";
                    $stmt_tags = $pdo->prepare($sql_tags);
                    $stmt_tags->execute([$pergunta['id']]);
                    $tags_pergunta = $stmt_tags->fetchAll();
                    ?>
                    
                    <?php if(count($tags_pergunta) > 0): ?>
                        <div class="tags">
                            <?php foreach($tags_pergunta as $tag): ?>
                                <a href="perguntas.php?tag=<?php echo urlencode($tag['nome']); ?>" class="tag">
                                    <?php echo htmlspecialchars($tag['nome']); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Ações para admin -->
                    <?php if($is_admin): ?>
                        <div class="acoes-pergunta">
                            <a href="editar_pergunta.php?id=<?php echo $pergunta['id']; ?>">
                                <button class="btn-secundario"> Editar</button>
                            </a>
                            <a href="../processamento/deletar_pergunta.php?id=<?php echo $pergunta['id']; ?>" 
                               onclick="return confirm('Tem certeza que deseja deletar esta pergunta?')">
                                <button class="btn-perigo"> Deletar</button>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            
            <!-- Paginação -->
            <?php if($total_paginas > 1): ?>
                <div class="paginacao">
                    <?php if($pagina_atual > 1): ?>
                        <a href="?pagina=<?php echo $pagina_atual - 1; ?>&busca=<?php echo urlencode($busca); ?>&tag=<?php echo urlencode($tag_filtro); ?>&ordenar=<?php echo $ordenar; ?>">
                            &laquo; Anterior
                        </a>
                    <?php endif; ?>
                    
                    <?php for($i = 1; $i <= $total_paginas; $i++): ?>
                        <?php if($i == $pagina_atual): ?>
                            <a href="?pagina=<?php echo $i; ?>&busca=<?php echo urlencode($busca); ?>&tag=<?php echo urlencode($tag_filtro); ?>&ordenar=<?php echo $ordenar; ?>" class="ativo">
                                <?php echo $i; ?>
                            </a>
                        <?php else: ?>
                            <a href="?pagina=<?php echo $i; ?>&busca=<?php echo urlencode($busca); ?>&tag=<?php echo urlencode($tag_filtro); ?>&ordenar=<?php echo $ordenar; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endif; ?>
                    <?php endfor; ?>
                    
                    <?php if($pagina_atual < $total_paginas): ?>
                        <a href="?pagina=<?php echo $pagina_atual + 1; ?>&busca=<?php echo urlencode($busca); ?>&tag=<?php echo urlencode($tag_filtro); ?>&ordenar=<?php echo $ordenar; ?>">
                            Próxima &raquo;
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
        <?php else: ?>
            <div class="mensagem-info">
                <p>Nenhuma pergunta encontrada.</p>
                <p><a href="nova_pergunta.php" class="btn-principal" style="margin-top: 10px;">Seja o primeiro a perguntar!</a></p>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>