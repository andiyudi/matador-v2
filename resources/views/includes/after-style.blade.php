<style>
    .chartCard {
    width: 100%;
    height: auto;
    background: rgba(239, 239, 240, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px; /* Tambahkan padding sesuai kebutuhan */
    margin-bottom: 20px; /* Tambahkan margin-bottom sesuai kebutuhan */
}

.chartBox {
    width: 100%; /* Sesuaikan lebar sesuai kebutuhan */
    padding: 20px;
    border-radius: 20px;
    border: solid 3px rgba(218, 223, 225, 0.2);
    background: rgba(232, 236, 241, 0.2);
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
