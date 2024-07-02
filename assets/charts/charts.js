document.addEventListener('DOMContentLoaded', function () {
    const ctx1 = document.getElementById('visitChart').getContext('2d');
    const visitsData = JSON.parse(document.getElementById('visitsData').textContent);
    
    const labels1 = visitsData.map(item => {
        const date = new Date(item.visitDate);
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        return date.toLocaleDateString('fr-FR', options);
    });
    
    const data1 = visitsData.map(item => item.visitCount);
    
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: labels1,
            datasets: [{
                label: 'Nombre de Visites',
                data: data1,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    stepSize: 1
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += context.raw.toFixed(0);
                            return label;
                        }
                    }
                }
            }
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const ctx2 = document.getElementById('viewsChart').getContext('2d');
    const chartData = JSON.parse(document.getElementById('chartData').textContent);
    
    new Chart(ctx2, {
        type: 'line', 
        data: {
            labels: Object.keys(chartData),
            datasets: [{
                label: 'Nombre de vues',
                data: Object.values(chartData),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                fill: true,
                tension: 0.4 
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
});
