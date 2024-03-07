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
                    procurementsData.forEach(function(item) {
                        labels.push(item.label);
                        values.push(item.value);
                        colors.push(item.color);
                    });

                    const ctx = document.getElementById('pieDiagram').getContext('2d');

                    if (chart){
                        chart.destroy();
                    }

                    chart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: values,
                                backgroundColor: colors,
                            }]
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
                                        let percentage = (value * 100 / sum).toFixed(2) + "%";
                                        return percentage;
                                    },
                                    color: '#fff',
                                }
                            },
                            hoverOffset: 4
                        }
                    });
                }
            });
        }
        function downloadPDF(){
            const canvas = document.getElementById('pieDiagram');
            const logoBase64Input = document.getElementById('logoBase64');
            const logoBase64Value = logoBase64Input.value;
            //create image
            const canvasImage = canvas.toDataURL('image/jpeg', 1.0);
            //image must go to PDF
            let pdf = new jsPDF('landscape');
            pdf.setFontSize(10);
            pdf.addImage(canvasImage, 'JPEG', 10, 30, 280, 150);
            pdf.addImage(logoBase64Value, 'JPEG', 5, 5, 20, 10);
            pdf.text(25, 10, "PT. Citra Marga Nusaphala Persada Tbk.");
            pdf.text(25, 15, "Divisi Umum - Departemen Pengadaan");
            pdf.save('diagram-pdf.pdf');
        }
        // Memuat data saat halaman dimuat
        getData();

        // Memperbarui data saat filter berubah
        $('#division, #official, #year').change(function () {
            getData();
        });

    });
</script>
