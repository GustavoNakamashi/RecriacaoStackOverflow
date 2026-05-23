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
            <span id="botao-fechar">&times;</span> <!--representação do X-->

            <div class="header-cadastro">
                <img src=../img/logo.png>
                <h2> <span style="font-family: inter"> 
                    Participe do StackOverflow </span> </h2>

            </div>

            <div class="conteudo-cadastro">

                <p style="font-size: 12px; font-family: Inter, sans-serif; font-weight: normal; color: #333; max-width: 440px;">
                Ao clicar em "Cadastrar-se", você concorda com nossos <span style="color: rgb(132, 174, 205);">termos de serviço</span> e confirma que leu nossa <span style="color: rgb(132, 174, 205);">política de privacidade</span> .
                </p>

                <form>

                    <label>Nome</label><br>
                    <input type="text" placeholder="Exemplo: João" name="inputNome"><br>
                
                    <label>Email</label><br>
                    <input type="text" placeholder="exemplo@gmail.com" name="inputEmail"><br>

                    <label>Senha</label><br>
                    <input type="password" placeholder="8+ caracteres (pelo menos uma letra e um número" name="inputSenha"><br>

                    <button>Cadastrar-se</button><br>

                    <p id="frase-final">Já tem uma conta? <a href="#" style=" text-decoration: none;"> <span style="color: blue;"> Iniciar sessão </span> </a></p>

                </form>
            <div>
        </div>    

    </section>


</body>
</html>