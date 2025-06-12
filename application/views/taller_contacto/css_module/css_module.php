<?= link_tag('/assets/css/theme-default.css') ?>
<style>
   
/* Reset y base */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f5f7fa;
    color: #333;
    margin: 0;
    padding: 0;
}

/* Panel general */
.panel.panel-default {
    background-color: #fff;
    padding: 30px 25px;
}

.panel-body{
    display: flex;
    align-items: center;
}
.contact-container {
    width: 80%;
    margin: 0 auto;    /* CENTRADO HORIZONTAL */
    padding: 25px;
    display: flex;
    border-radius: 12px;
    background: #fff;
    box-shadow: rgba(14, 30, 37, 0.12) 0px 2px 4px 0px, rgba(14, 30, 37, 0.32) 0px 2px 16px 0px;
    overflow: hidden;
}


.contact-method {
    font-size: 1.2rem;
    margin: 1rem 0;
    color: #333;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    cursor: pointer;
    transition: background-color 0.2s ease;
    padding: 10px;
    border-radius: 6px;
}

.contact-method:hover {
    background-color: #f0f8ff;
}


.contact-info i {
    color: #007bff;
    font-size: 1.3rem;
}


.contact-info h1 {
    font-weight: 900;
    font-size: 2.5rem;
    margin-bottom: 1rem;
}


/* Labels */
.form-group label.control-label {
    color: #212529;
    margin-bottom: 0.4rem;
    font-weight: 700;
}

/* Inputs y textarea */
.form-control {
    border-radius: 8px;
    border: 1.5px solid #ced4da;
    padding: 10px 14px;
    font-size: 1rem;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 8px rgba(0,123,255,0.25);
    outline: none;
}

/* Botón */
.btn-primary {
    background-color: #007bff;
    border: none;
    font-size: 1.2rem;
    padding: 12px 50px;
    border-radius: 8px;
    font-weight: 700;
    transition: background-color 0.3s ease;
    box-shadow: 0 4px 8px rgba(0,123,255,0.2);
}

.btn-primary:hover,
.btn-primary:focus {
    background-color: #0056b3;
    box-shadow: 0 6px 12px rgba(0,86,179,0.4);
}

/* Centrado texto en boton */
.form-group .text-center {
    margin-top: 20px;
}

/* Responsive para pantallas pequeñas */
@media (max-width: 767px) {
    .contact-container {
        flex-direction: column;
    }
    .contact-container > div.col-md-6 {
        flex: 1 1 100%;
        min-width: auto;
    }
}



</style>
