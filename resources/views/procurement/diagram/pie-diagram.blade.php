<script>
    $(document).ready(function () {

        let chart;
        Chart.register(ChartDataLabels);

        function getData(){
            $.ajax({
                url: '{{ route('diagram.pieDiagram') }}',
                type: "GET",
                dataType: "json",
                data: {
                    'division' : $("#division").val(),
                    'official' : $("#official").val(),
                    'year' : $("#year").val(),
                },
                success: function (response) {
                    const procurementsData = response; // Mengakses data dari respons JSON
                    const labels = [];
                    const values = [];
                    const colors = [];

                    // Mengekstrak label, nilai, dan warna dari respons JSON
                    if (procurementsData.length === 0) {
                        // Jika tidak ada data, tampilkan "No Data Available"
                        labels.push("No Data Available");
                        values.push(0);
                        colors.push("rgba(169, 169, 169, 0.6)"); // Warna abu-abu
                    } else {
                        procurementsData.forEach(function(item) {
                            labels.push(item.label + " : " + item.value);
                            values.push(item.value);
                            colors.push(item.color);
                        });
                    }

                    const ctx = document.getElementById('pieDiagram').getContext('2d');

                    if (chart){
                        chart.destroy();
                    }
                    const bgColor = {
                        id: 'bgColor',
                        beforeDraw: (chart, steps, options) => {
                            const { ctx, width, height} = chart;
                            ctx.fillStyle = options.backgroundColor;
                            ctx.fillRect(0, 0, width, height);
                            ctx.restore();
                        }
                    }

                    chart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: values,
                                backgroundColor: colors,
                                borderColor: colors, // Set border color sama dengan warna elemen
                                borderWidth: 1,
                                cutout: '60%',
                                borderRadius: 10,
                                offset: 5,
                            }],
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                datalabels: {
                                    formatter: (value, ctx) => {
                                        let sum = 0;
                                        let dataArr = ctx.chart.data.datasets[0].data;
                                        dataArr.map(data => {
                                            sum += data;
                                        });
                                        let percentage = (value * 100 / sum).toFixed(2);
                                        if (isNaN(percentage)) {
                                            return 'No Data Available'; // Return empty string if percentage is NaN
                                        } else {
                                            return percentage + "%";
                                        }
                                    },
                                color: 'black',
                                },
                                bgColor: {
                                    backgroundColor: 'white',
                                },
                                legend: {
                                    position: 'right',
                                    anchor: 'end',
                                    align: 'center',
                                    labels: {
                                        usePointStyle: true,
                                        pointStyle: 'circle',
                                    },
                                },
                            },
                            hoverOffset: 4,
                            aspectRatio: 1,
                        },
                        plugins: [bgColor],
                    });
                }
            });
        }
        // Memuat data saat halaman dimuat
        getData();

        // Memperbarui data saat filter berubah
        $('#division, #official, #year').change(function () {
            getData();
        });
    });
    function downloadPDF(){
            const canvas = document.getElementById('pieDiagram');
            const logoBase64Input = document.getElementById('logoBase64');
            const logoBase64Value = logoBase64Input.value;
            //create image
            const canvasImage = canvas.toDataURL('image/jpeg', 1.0);
            //image must go to PDF
            let pdf = new jsPDF();
            pdf.setFontSize(10);
            pdf.addImage(canvasImage, 'JPEG', 25, 20, 150, 150);
            pdf.addImage(logoBase64Value, 'JPEG', 5, 15, 20, 10);
            pdf.text(25, 20, "PT. Citra Marga Nusaphala Persada Tbk.");
            pdf.text(25, 25, "Divisi Umum - Departemen Pengadaan");
            pdf.save('diagram-pdf.pdf');
        }
</script>
