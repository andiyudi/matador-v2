<style>
    @media print{
        @page {
            size: A4 landscape;
        }
    }
    body {
        font-family: 'Arial Narrow', sans-serif; /* Arial Narrow */
        font-size:10pt; /* Ukuran huruf 10px */
    }
    .peserta-rapat table {
        border-collapse: collapse;
        width: 100%;
        table-layout: fixed;
        word-wrap: break-word;
    }
    .peserta-rapat th {
        background-color:rgb(20, 55, 85);
        color : white;
        border: 1px solid black;
        padding: 8px;
        vertical-align: middle;
    } .peserta-rapat td {
        border: 1px solid black;
        padding: 8px;
        vertical-align: middle;
    }
    .row {
        display: flex;
        justify-content: space-between;
    }
    .col-md-4 {
        width: 48%; /* Sesuaikan lebar div dengan tabel di dalamnya */
    }
    .col-md-8 {
        width: 67%; /* Sesuaikan lebar div dengan tabel di dalamnya */
    }
    .total-column {
        background-color:deepskyblue;
    }
    .document-pic table {
        border-collapse: collapse; /* Menyatukan batas seluruhnya */
        width: 100%;
        font-size:8pt;
    }
    .document-pic th,
    .document-pic td {
        border: 1px solid black; /* Batas individual */
        padding: 3px;
        vertical-align: middle;
        text-align: center;
    }
</style>
