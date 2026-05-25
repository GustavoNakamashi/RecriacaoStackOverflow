// Conteúdo do arquivo: grafico.js

const ctx = document.getElementById('graficoReputacao').getContext('2d');

const dadosPontos = [10, 30, 45, 80, 120, 150]; 
const meses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'];

new Chart(ctx, {
    type: 'line',
    data: {
        labels: meses,
        datasets: [{
            label: 'Evolução da Reputação',
            data: dadosPontos,
            borderColor: '#4CAF50',
            backgroundColor: 'rgba(76, 175, 80, 0.2)',
            borderWidth: 2,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});


const ctxAtividade = document.getElementById('graficoAtividade').getContext('2d');

new Chart(ctxAtividade, {
    type: 'doughnut',
    data: {
        labels: ['Perguntas', 'Respostas'],
        datasets: [{
            data: [12, 35], // Dados fictícios para testar o layout
            backgroundColor: ['#f48024', '#0077cc'] // Cores clássicas do Stack Overflow (Laranja e Azul)
        }]
    },
    options: {
        responsive: true
    }
});


// Captura o canvas do Gráfico de Barras
const ctxBarras = document.getElementById('graficoBarrasTags').getContext('2d');

// Dados mockados: as tecnologias que o usuário mais respondeu e a quantidade
const tagsPrincipais = ['JavaScript', 'PHP', 'Python', 'HTML/CSS', 'SQL'];
const quantidadeRespostas = [25, 18, 12, 9, 4];

new Chart(ctxBarras, {
    type: 'bar', // Define que o gráfico é de barras
    data: {
        labels: tagsPrincipais, // Legendas do Eixo X
        datasets: [{
            label: 'Respostas Dadas',
            data: quantidadeRespostas, // Valores do Eixo Y
            // Uma cor diferente para cada barra para ficar bem visual
            backgroundColor: [
                '#f1e05a', // Amarelo para JS
                '#4f5d95', // Roxo para PHP
                '#3572A5', // Azul para Python
                '#e34c26', // Laranja para HTML
                '#e38c00'  // Ouro para SQL
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false // Esconde a legenda global porque cada barra já é uma tag diferente
            }
        },
        scales: {
            y: {
                beginAtZero: true, // Garante que o gráfico comece do número 0
                title: {
                    display: true,
                    text: 'Nº de Respostas'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Tecnologias'
                }
            }
        }
    }
});