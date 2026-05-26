<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StackOverflow Fatec - Desafios</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>

<ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="nova_pergunta.php">Nova Pergunta</a></li>
    <li><a href="buscar.php">Buscar</a></li>
    <li><a class="active" href="desafios.php">Desafios</a></li>
    <li><a href="perfilUsuario.php">Perfil</a></li>
</ul>

<div class="conteudo-principal">
    <div class="container">
        <h1> Desafios de Programação</h1>
        <p class="subtitulo">Teste suas habilidades com desafios semanais!</p>
        
        <?php
        session_start();
        require_once 'config/conexao.php';
        
        // Verificar se é admin (usuário com id = 1)
        $is_admin = isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] == 1;
        
        if($is_admin): ?>
            <div class="admin-panel">
                <h3>Painel do Administrador</h3>
                <form method="POST" action="processamento/desafios_admin.php">
                    <input type="hidden" name="acao" value="criar">
                    <input type="text" name="titulo" placeholder="Título do desafio" required>
                    <textarea name="descricao" placeholder="Descrição do desafio (requisitos, exemplo de entrada/saída...)" required></textarea>
                    <select name="dificuldade">
                        <option value="Fácil">Fácil</option>
                        <option value="Médio">Médio</option>
                        <option value="Difícil">Difícil</option>
                    </select>
                    <button type="submit" class="btn-admin">+ Criar Desafio</button>
                </form>
            </div>
        <?php endif; ?>
        
        <?php
        $sql = "SELECT * FROM desafios ORDER BY 
                CASE dificuldade 
                    WHEN 'Fácil' THEN 1 
                    WHEN 'Médio' THEN 2 
                    WHEN 'Difícil' THEN 3 
                END, data_publicacao DESC";
        $stmt = $pdo->query($sql);
        $desafios = $stmt->fetchAll();
        
        if(count($desafios) > 0) {
            foreach($desafios as $desafio): ?>
                <div class="desafio-item">
                    <span class="dificuldade dificuldade-<?php echo $desafio['dificuldade']; ?>">
                        <?php echo $desafio['dificuldade']; ?>
                    </span>
                    <h2><?php echo htmlspecialchars($desafio['titulo']); ?></h2>
                    <div class="desafio-descricao"><?php echo nl2br(htmlspecialchars($desafio['descricao'])); ?></div>
                    <div class="desafio-data"> Publicado em: <?php echo date('d/m/Y', strtotime($desafio['data_publicacao'])); ?></div>
                    
                    <?php if($is_admin): ?>
                        <form method="POST" action="processamento/desafios_admin.php" style="margin-top: 15px;">
                            <input type="hidden" name="acao" value="deletar">
                            <input type="hidden" name="id" value="<?php echo $desafio['id']; ?>">
                            <button type="submit" class="btn-perigo" onclick="return confirm('Tem certeza que deseja deletar este desafio?')"> Deletar</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach;
        } else {
            echo '<p>Nenhum desafio cadastrado ainda.</p>';
        }
        ?>
    </div>
</div>

</body>
</html>