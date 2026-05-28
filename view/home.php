<?php
date_default_timezone_set('America/Sao_Paulo');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StackOverflow Fatec - IA Assistente</title>
    <link rel="stylesheet" href="../css/styleHome.css">
</head>
<body>

<!-- MENU LATERAL -->
<ul class="menu-lateral">
    <li><a class="active" href="home.php">Home</a></li>
    <li><a href="perfilUsuario.php">Perfil</a></li>
    <li><a href="desafio.php">Desafios</a></li>
    <li><a href="perguntas.php">Perguntas</a></li>
</ul>

<!-- CONTEUDO PRINCIPAL -->
<div class="conteudo-principal">
    <div class="chat-header">
        <h1>Assistente de Programacao IA</h1>
        <p>Tire suas duvidas sobre codigo, linguagens, frameworks e muito mais</p>
    </div>

    <div class="chat-container">
        <div class="chat-messages" id="chatMessages">
            <div class="message bot">
                <div class="bubble">Ola! Eu sou o assistente de programacao. Pergunte qualquer coisa!</div>
                <div class="time"><?= date('H:i') ?></div>
            </div>
        </div>

        <div class="input-area">
            <input type="text" id="messageInput" class="chat-input" placeholder="Digite sua pergunta aqui..." autocomplete="off">
            <button class="send-btn" id="sendBtn">➤</button>
        </div>
    </div>
</div>

<script>
    const chatMessages = document.getElementById('chatMessages');
    const messageInput = document.getElementById('messageInput');
    const sendBtn = document.getElementById('sendBtn');
    
    function addMessage(text, isUser) {
        const div = document.createElement('div');
        div.className = 'message ' + (isUser ? 'user' : 'bot');
        
        const bubble = document.createElement('div');
        bubble.className = 'bubble';
        bubble.innerHTML = text.replace(/\n/g, '<br>');
        
        const time = document.createElement('div');
        time.className = 'time';
        const agora = new Date();
        time.textContent = agora.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        
        div.appendChild(bubble);
        div.appendChild(time);
        chatMessages.appendChild(div);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    
    function enviarMensagem() {
        const mensagem = messageInput.value.trim();
        if (mensagem === '') return;
        
        addMessage(mensagem, true);
        messageInput.value = '';
        addMessage('Obrigado pela pergunta! Estou aprendendo para responder melhor.', false);
    }
    
    sendBtn.addEventListener('click', enviarMensagem);
    messageInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') enviarMensagem();
    });
</script>

</body>
</html>