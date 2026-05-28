<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StackOverflow Fatec - IA Assistente</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <link rel="stylesheet"  href="..//css/styleHome.css">
    
</head>
<body>

<!-- MENU LATERAL -->
<ul>
    <li><a class="active" href="home.php">Home</a></li>
    <li><a href="perfilUsuario.php">Perfil</a></li>
    <li><a href="desafio.php">Desafios</a></li>
    <li><a href="perguntas.php">Perguntas</a></li>
</ul>

<!-- CONTEÚDO PRINCIPAL -->
<div class="main-content">
    <div class="chat-header">
        <h1>Assistente de Programação IA</h1>
        <p>Tire suas dúvidas sobre código, linguagens, frameworks e muito mais</p>
    </div>

    <div class="chat-container">
        <div class="chat-messages" id="chatMessages">
            <div class="message bot-message">
                <div class="message-bubble">
                    Olá! Eu sou o assistente de programação. Pergunte qualquer coisa sobre código, linguagens, frameworks ou desafios de programação!
                </div>
                <div class="message-time"><?= date('H:i') ?></div>
            </div>
        </div>

        <div class="loading" id="loading">Digitando...</div>

        <div class="chat-input-area">
            <div class="input-wrapper">
                <input type="text" id="messageInput" class="chat-input" placeholder="Digite sua pergunta aqui..." autocomplete="off">
                <button class="send-btn" id="sendBtn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    const chatMessages = document.getElementById('chatMessages');
    const messageInput = document.getElementById('messageInput');
    const sendBtn = document.getElementById('sendBtn');
    const loading = document.getElementById('loading');
    
    function addMessage(text, isUser) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${isUser ? 'user-message' : 'bot-message'}`;
        
        const bubble = document.createElement('div');
        bubble.className = 'message-bubble';
        bubble.innerHTML = text.replace(/\n/g, '<br>');
        
        const time = document.createElement('div');
        time.className = 'message-time';
        const agora = new Date();
        time.textContent = agora.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        
        messageDiv.appendChild(bubble);
        messageDiv.appendChild(time);
        chatMessages.appendChild(messageDiv);
        
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    
    function mostrarLoading() {
        loading.style.display = 'block';
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    
    function esconderLoading() {
        loading.style.display = 'none';
    }
    
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    async function enviarMensagem() {
        const mensagem = messageInput.value.trim();
        if (mensagem === '') return;
        
        addMessage(escapeHtml(mensagem), true);
        messageInput.value = '';
        mostrarLoading();
        
        try {
            const response = await fetch('../processamento/chat.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'mensagem=' + encodeURIComponent(mensagem)
            });
            
            const data = await response.json();
            esconderLoading();
            
            if (data.resposta) {
                addMessage(data.resposta, false);
            } else if (data.erro) {
                addMessage('Erro: ' + data.erro, false);
            } else {
                addMessage('Desculpe, não consegui processar sua pergunta.', false);
            }
        } catch (error) {
            esconderLoading();
            addMessage('Erro de conexão. Tente novamente.', false);
        }
    }
    
    sendBtn.addEventListener('click', enviarMensagem);
    messageInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') enviarMensagem();
    });
</script>

</body>
</html>