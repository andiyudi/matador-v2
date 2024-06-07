<style>
    /* styles.css */
body {
    font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif
    line-height: 1;
    margin: 0;
    font-size: 11pt;
    text-align: justify;
}

.container {
    padding: 20px;
    margin: 20px auto;
    border-radius: 5px;
    max-width: 800px;
}

h4 {
    text-align: center;
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

table, th, td {
    border: 1px solid #000000;
}

th, td {
    padding: 10px;
    text-align: center;
}

th {
    background-color: #b3aeae;
    text-align: center;
}

.footer {
    text-align: right;
    margin-top: 20px;
}

/* Optional: Customize the ordered list style */
ol {
    counter-reset: list-counter;
    list-style-type: none;
    padding-left: 20px;
}

ol li {
    counter-increment: list-counter;
    position: relative;
    margin-bottom: 5px;
    margin-left: 10px;
}

ol li::before {
    content: counter(list-counter) ". ";
    position: absolute;
    left: -20px;
}


/* Print styles */
@page {
    size: A4 landscape;
    margin: 20mm;
}

@media print {
    body {
        background: none;
        margin: 0;
    }

    .container {
        box-shadow: none;
        max-width: none;
        width: 100%;
        margin: 0;
        padding: 0;
    }

    .footer {
        page-break-after: avoid;
    }
}

</style>
