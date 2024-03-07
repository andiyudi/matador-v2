<style>
    .chartCard {
    width: 100%;
    height: auto;
    background: rgba(54, 162, 235, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px; /* Tambahkan padding sesuai kebutuhan */
    margin-bottom: 20px; /* Tambahkan margin-bottom sesuai kebutuhan */
}

.chartBox {
    width: 100%; /* Sesuaikan lebar sesuai kebutuhan */
    max-width: 700px; /* Sesuaikan lebar maksimum sesuai kebutuhan */
    height: 400px; /* Sesuaikan tinggi sesuai kebutuhan */
    padding: 20px;
    border-radius: 20px;
    border: solid 3px rgba(54, 162, 235, 1);
    background: white;
}
.chartBox button {
    margin-top: 10px; /* Atur jarak antara tombol dan diagram */
    color: white; /* Atur warna teks */
    background-color: rgba(54, 162, 235, 1); /* Atur warna latar belakang */
    border: none; /* Hilangkan border */
    border-radius: 5px; /* Atur sudut border */
    padding: 5px 10px; /* Atur padding */
}


    @media (min-width: 768px) {
        .chartCard {
            height: 600px; /* Sesuaikan tinggi sesuai kebutuhan */
        }

        .chartBox {
            width: 80%; /* Sesuaikan lebar sesuai kebutuhan */
        }
    }

    @media (min-width: 992px) {
        .chartBox {
            width: 60%; /* Sesuaikan lebar sesuai kebutuhan */
        }
    }

    @media (min-width: 1200px) {
        .chartBox {
            width: 50%; /* Sesuaikan lebar sesuai kebutuhan */
        }
    }
</style>
