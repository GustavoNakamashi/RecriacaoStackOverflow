    <link rel="stylesheet" href="../css/sub_dashboard.css">

    <section class="secao-cards">
        <div class="cards"  style="background-color: rgb(24, 67, 100);">
            <div class="espacamento-palavras">
                <h3 style="color: rgb(255, 255, 255);">Reputação</h3>
            </div>
        </div>

        <div class="cards">
            <div class="espacamento-palavras">
                <h3>Perguntas feitas</h3>
            </div>
        </div>

        <div class="cards">
            <div class="espacamento-palavras">
                <h3>Respostas Úteis</h3>
            </div>
        </div>

        <div class="cards">
            <div class="espacamento-palavras">
                <h3>Seguidores</h3>
            </div>
        </div>
    </section>



    <div class="dashboard-layout-global">

    <div class="coluna-esquerda">
        
        <div class="caixa-grafico-individual">
            <canvas id="graficoReputacao"></canvas>
        </div>

        <div class="caixa-grafico-individual" style="margin-top: 30px;">
            <canvas id="graficoBarrasTags"></canvas>
        </div>

    </div>

    <div class="coluna-direita">
        <div class="caixa-grafico-rosca-fixo">
            <canvas id="graficoAtividade"></canvas>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../processamento/dashboard.js"></script>