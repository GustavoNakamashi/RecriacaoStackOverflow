<!DOCTYPE html>
<html lang="pt-BR">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Usuário</title>

    <link rel="stylesheet" href="../css/perfilUsuario.css">

    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">


</head>

<body>
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="perguntas.php">Questões</a></li>
        <li><a href="desafio.php">Desafios</a></li>
        <li><a class="active" href="#perfilUsuario.php">Perfil</a></li>
    </ul>

    <section class="corpo-principal">
        <div id="deixar-flexivel">
            <img src="../img/logo.png" alt="Foto de perfil" class="foto-perfil">
            <h1> Nome </h1>
        </div>

        <div>
            <a href="PerfilUsuario.php?pagina=perguntas.php">
                <button type="button">Suas perguntas</button>
            </a>
            
            <a href="PerfilUsuario.php?pagina=dashboard">
                <button type="button">Dashboard</button>
            </a>

            <a href="PerfilUsuario.php?pagina=perfil">
                <button type="button">Editar Perfil</button>
            </a>

        </div>    

        <div class="conteudo-dinamico">
            <?php 
            include '../processamento/controlaAbas.php'; 
            ?>
        </div>

        

    </section>


</body>
</html>