document.addEventListener('DOMContentLoaded', function(){

    const categories = document.querySelector('#categories');
    let tabValue = document.querySelector('.js-tab-value');
    
    let dataGraph = JSON.parse(tabValue.dataset.abs, true);
    
    
    const cateGraph = new Chart(categories, {
        type: "doughnut",
        data: {
            labels: ['En cours', 'A venir', 'Termine', 'Suspendu', 'Arrete'],
            datasets: [{
                data: dataGraph,
                backgroundColor: [
                    'rgba(37, 32, 32, 1)',
                    'rgba(30, 154, 211, 1)',
                    'rgba(30, 121, 30, 1)',
                    'rgba(151, 52, 138, 1)',
                    'rgba(170, 19, 24, 1)'
                ]
        }]
    }
    })

})


