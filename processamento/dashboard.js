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
            borderColor: '#3572A5',
            backgroundColor: 'rgba(76, 175, 80, 0.2)',
            borderWidth: 2,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

const ctxBarras = document.getElementById('graficoBarrasTags').getContext('2d');

const tagsPrincipais = ['JavaScript', 'PHP', 'Python', 'HTML/CSS', 'SQL'];
const quantidadeRespostas = [25, 18, 12, 9, 4];

new Chart(ctxBarras, {
    type: 'bar',
    data: {
        labels: tagsPrincipais,
        datasets: [{
            label: 'Respostas Dadas',
            data: quantidadeRespostas,
            
            backgroundColor: [
                '#f1e05a',
                '#3572A5',
                '#f1e05a',
                '#3572A5',
                '#f1e05a' 
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
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

const ctxAtividade = document.getElementById('graficoAtividade').getContext('2d');

new Chart(ctxAtividade, {
    type: 'doughnut',
    data: {
        labels: ['Perguntas', 'Respostas'],
        datasets: [{
            data: [12, 35],
            backgroundColor: ['#f1e05a', '#3572A5']
        }]
    },
    options: {
        responsive: true
    }
});