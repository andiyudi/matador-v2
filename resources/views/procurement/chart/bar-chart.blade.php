<script>
    $(document).ready(function() {

    let chart;
    Chart.register(ChartDataLabels);

    function getData(){
        $.ajax({
            url: route('chart.barChart'),
            method: 'GET',
            dataType: 'json',
            data: {
                'division' : $("#division").val(),
                'official' : $("#official").val(),
                'year' : $("#year").val(),
            },
            success:function(data){

                const procurementsData = data.procurementsData;

                const ctx = document.getElementById('barChart').getContext('2d');

                if (chart){
                    chart.destroy();
                }
                // Extract data from the response
                const labels = Object.keys(procurementsData);
                const dataEEUser = labels.map(month => procurementsData[month].user_estimates !== null ? procurementsData[month].user_estimates : 0);
                const dataDealNego = labels.map(month => procurementsData[month].deal_negos !== null ? procurementsData[month].deal_negos : 0);
                const dataUserPercentage = labels.map(month => procurementsData[month].user_percentages !== null ? procurementsData[month].user_percentages : 0);

                const maxDataValue = Math.max(...dataEEUser, ...dataDealNego);
                const step = calculateStep(maxDataValue); // Define a function to calculate the step based on your logic
                const maxAxisValue = Math.ceil(maxDataValue / step) * step + step;
                const maxDataValuePercentage = Math.max(...dataUserPercentage);
                const orderOfMagnitudePercentage = Math.pow(10, Math.floor(Math.log10(maxDataValuePercentage)));
                const stepPercentage = orderOfMagnitudePercentage / 5;
                const maxAxisValuePercentage = (Math.ceil(maxDataValuePercentage / stepPercentage) * stepPercentage + stepPercentage).toFixed(2);

                chart = new Chart(ctx,{
                    type:'scatter',
                    data:{
                        labels: labels,
                        datasets: [
                            {
                            type: 'bar',
                            label: 'EE User',
                            data: dataEEUser,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                            yAxisID: 'left-y-axis',
                            },
                            {
                            type: 'bar',
                            label: 'Hasil Negosiasi',
                            data: dataDealNego,
                            backgroundColor: 'rgba(75, 192, 102, 0.2)',
                            borderColor: 'rgba(75, 192, 102, 1)',
                            borderWidth: 1,
                            yAxisID: 'left-y-axis',
                            },
                            {
                            type: 'line',
                            label: '% User',
                            data: dataUserPercentage,
                            borderColor: 'rgb(75, 192, 192)',
                            lineTension: 0,
                            fill: false,
                            borderColor: 'orange',
                            backgroundColor: 'transparent',
                            borderDash: [5, 5],
                            pointBorderColor: 'orange',
                            pointBackgroundColor: 'rgba(255,150,0,0.5)',
                            pointRadius: 5,
                            pointHoverRadius: 10,
                            pointHitRadius: 30,
                            pointBorderWidth: 2,
                            pointStyle: 'rectRounded',
                            yAxisID: 'right-y-axis',
                            },
                        ]
                    },
                    options:{
                        responsive:true,
                        scales:{
                            'left-y-axis': {
                                type: 'linear',
                                position: 'left',
                                max: maxAxisValue,
                                beginAtZero: true,
                                title : {
                                    display : true,
                                    text : 'Rupiah'
                                },
                            },
                            'right-y-axis': {
                                type: 'linear',
                                position: 'right',
                                min: 0,
                                beginAtZero: true,
                                title : {
                                    display : true,
                                    text : 'Persentase',
                                },
                                ticks: {
                                    callback: ((value, index, values)=>{
                                    return `${value}%`
                                    })
                                },
                                max: maxAxisValuePercentage,
                                grid: {
                                    drawOnChartArea: false, // only want the grid lines for one axis to show up
                                },
                            },
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom',
                            },
                            datalabels: {
                                display: true,
                                align: 'top',
                                anchor: 'end',
                                formatter: function (value, context) {
                                    if (value !== null && value !== undefined) {
                                        if (context.dataset.label === 'EE User' || context.dataset.label === 'Hasil Negosiasi') {
                                            return value !== 0 ? 'Rp. ' + value.toFixed(0).replace(/\d(?=(\d{3})+$)/g, '$&.') : '';
                                        } else if (context.dataset.label === '% User') {
                                            return value !== 0 ? value + '%' : '';
                                        } else {
                                            return value || 0;
                                        }
                                    } else {
                                        return ''; // Mengembalikan string kosong jika nilai null atau undefined
                                    }
                                },
                                color: ((context, args)=>{
                                    const datasetIndex = context.datasetIndex;
                                    const colorMap = ['rgba(255, 99, 132, 1)', 'rgba(75, 192, 102, 1)'];
                                    return colorMap[datasetIndex] || 'orange'
                                })
                            },
                        },
                    }
                })
            },
            error: function(error){
                console.log(error);
            }
        })
    }
    getData();
    function calculateStep(maxValue) {
        // Your logic to calculate the step based on the maxValue
        // For example, you can use a dynamic step based on the order of magnitude of the maxValue
        const orderOfMagnitude = Math.pow(10, Math.floor(Math.log10(maxValue)));
        return orderOfMagnitude / 5; // Adjust the divisor as needed
    }
      // Tambahkan event listener untuk pembaruan ketika filter diubah
    $('#division, #official, #year').on('change', function() {
        getData();
    });
});
</script>
