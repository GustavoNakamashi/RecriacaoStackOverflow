<link rel="stylesheet" href="../css/sub_perfil.css">

<form>
    <div class="layout-duas-colunas"> 
        
        <div class="coluna">
            <div class="campos">
                <label>Nome</label><br>
                <input type="text" placeholder="Nome" name="inputNome" id="nome">
            </div>
            
            <div class="campos">
                <label>Sobrenome</label><br>
                <input type="text" placeholder="Sobrenome" name="inputSobrenome" id="sobrenome">
            </div>

            <div class="campos">
                <label>CEP</label><br>
                <input type="text" placeholder="00000-000" name="inputCep" id="cep">
            </div>

            <div class="campos">
                <label>Logradouro</label><br>
                <input type="text" placeholder="Rua, Avenida, etc." name="inputLogradouro" id="logradouro">
            </div>

            <div class="campos">
                <label>Estado</label><br>
                <input type="text" placeholder="São Paulo, Minas Gerais" name="inputEstado" id="estado">
            </div>
        </div>

        <div class="coluna">
            <div class="campos">
                <label>Complemento</label><br>
                <input type="text" placeholder="Apto, Bloco, Casa" name="inputComplemento" id="complemento">
            </div>

            <div class="campos">
                <label>Bairro</label><br>
                <input type="text" placeholder="Bairro" name="inputBairro" id="bairro">
            </div>
            
            <div class="campos">
                <label>Localidade</label><br>
                <input type="text" placeholder="Cidade" name="inputLocalidade" id="localidade">
            </div>

            <div class="campos">
                <label>UF</label><br>
                <input type="text" placeholder="SP, MG, etc." name="inputUf" id="uf">
            </div>

        </div>

    </div>

    <button class="botao-salvar centro">Confirmar</button>
</form>


<script src="../processamento/perfil.js"></script>