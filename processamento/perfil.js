// Aguarda o usuário sair do campo de CEP
document.getElementById('cep').addEventListener('blur', function() {
    
    // Pega o valor digitado e remove tudo que não for número (ex: hífens)
    let cep = this.value.replace(/\D/g, '');

    // Verifica se o CEP possui exatamente 8 dígitos
    if (cep.length === 8) {
        
        // Monta a URL da API da ViaCEP
        let url = `https://viacep.com.br/ws/${cep}/json/`;

        // Faz a requisição
        fetch(url)
            .then(response => response.json()) // Converte a resposta para JSON
            .then(data => {
                // Verifica se a API retornou um erro (CEP inexistente)
                if (data.erro) {
                    alert("CEP não encontrado.");
                    return;
                }

                // Preenche os campos do formulário com os dados recebidos
                document.getElementById('logradouro').value = data.logradouro;
                document.getElementById('bairro').value = data.bairro;
                document.getElementById('localidade').value = data.localidade;
                document.getElementById('uf').value = data.uf;
                document.getElementById('estado').value = data.estado; 
                
                // Opcional: focar no campo de número/complemento após preencher
                document.getElementById('complemento').focus();
            })
            .catch(error => {
                console.error("Erro ao buscar o CEP:", error);
                alert("Ocorreu um erro ao buscar o CEP. Tente novamente mais tarde.");
            });
    } else if (cep.length > 0) {
        // Se o usuário digitou algo, mas não tem 8 números
        alert("Formato de CEP inválido.");
    }
});