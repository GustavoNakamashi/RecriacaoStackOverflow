<!DOCTYPE html>
<html lang="pt-BR">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CadUsuario</title>

    <link rel="stylesheet" href="../css/styleCadUsuario.css">
    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">

</head>
<body>

    <section id="centralizando-tela-cadastro">
        <div class="tela-cadastro">
            
            <img src=../img/logo.png>
            <h2> Participe do StackOverflow <h2>
            
            <p style="font-size: 12px; font-family: Inter, sans-serif; font-weight: normal; color: #333; max-width: 440px;">
            Ao clicar em "Cadastrar-se", você concorda com nossos termos de serviço e confirma que leu nossa política de privacidade .
            </p>

            <form>

                <label>Nome</label><br>
                <input type="text" placeholder="Nome" name="inputNome"><br>
            
                <label>Email</label><br>
                <input type="text" placeholder="Email" name="inputEmail"><br>

                <label>Senha</label><br>
                <input type="password" placeholder="Senha" name="inputSenha"><br>

                <button>Cadastrar-se</button><br>

                <p id="frase-final">Já tem uma conta? <a href="#" style=" text-decoration: none;"> <span style="color: blue;"> Iniciar sessão </span> </a></p>

            </form>
        </div>    

    </section>


</body>
</html>