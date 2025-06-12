<?= link_tag('/assets/css/theme-default.css') ?>
<style>
     body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #f4f6f9;
        color: #333;
    }

    .jumbotron {
        background: linear-gradient(-45deg, #004085, #0069d9, #0056b3, #003366);
        background-size: 400% 400%;
        animation: fondoAnimado 10s ease infinite;
        color: white;
        border-radius: 0px;
        padding: 2rem 3rem;
        margin-bottom: 30px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
    }

    @keyframes fondoAnimado {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }


    .dashboard-box {
        background: #ffffff;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease;
    }

    .dashboard-box:hover {
        transform: translateY(-5px);
    }

    .dashboard-box h3 {
        font-size: 18px;
        margin-bottom: 10px;
        color: #004085;
    }

    .dashboard-box p {
        font-size: 14px;
        color: #666;
    }

    .panel {
        border-radius: 12px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
        border: none;
    }

    .panel-heading {
        background-color: #003366 !important;
        color: white !important;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
        font-weight: bold;
    }

    .panel-footer {
        background-color: #f1f1f1;
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    .badge {
        background-color: #0069d9;
        padding: 5px 10px;
        border-radius: 10px;
        font-size: 12px;
    }

    .alert-warning {
        border-radius: 10px;
        padding: 15px 20px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
    }

    .table > thead > tr > th {
        background-color: #f8f9fa;
        color: #333;
    }

    .table-striped > tbody > tr:nth-child(odd) {
        background-color: #f9f9f9;
    }
</style>