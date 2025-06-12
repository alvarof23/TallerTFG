<?= link_tag('/assets_back_office/css/theme-default.css') ?>
<style>

    .vcenter{
        display: inline-block;
        vertical-align: middle;
        float:none;
    }

    .m-auto{
        margin: auto;
    }

    .imgModelo
    { 
        max-width: 120px;  
    }

    .divImgModelo
    {
        align-content: center;
        
        height: 120px;
        width: 120px;
    }

    .divImgModelo p{

        text-align: center;
        color: grey;
    }

    .col_sel
    {
        align-items: center;
    }

    /* Estilo para el cuerpo del modal */
    .body_img {
        overflow: hidden; /* Evita que la imagen se desborde */
    }

    /* Estilo para la imagen dentro del modal */
    #modalImage {
        width: 100%;
        height: auto;
        object-fit: contain; /* Mantiene la relación de aspecto */
        cursor: zoom-in;
        transition: transform 0.25s ease;
    }

    /* Estilo para el zoom de la imagen cuando se hace clic */
    .zoomed {
        cursor: zoom-out;
    }

    
    #boton_citas{
        border-radius: 100% ; 
        width: 30px ; 
        height: 30px ; 
        display: flex ; 
        align-items: center ; 
        justify-content: center ;
    }

    #div_botones {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .btns-izquierda {
        display: flex;
        align-items: center;
    }

    .btns-derecha {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .boton_citas {
        border-radius: 100%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .hora-select-seleccionada {
        background-color: green;
        color: black;
    }



</style>


<style>

   .modal_ficha_cita, .modal_recogida {
        height: 80% ;
    }

    /* form cita */
    .form-step {
        display: none;
        opacity: 0;
        transform: translateX(30px);
        transition: all 0.3s ease;
    }
    .form-step.active {
        display: block;
        opacity: 1;
        transform: translateX(0);
    }


    .modal-content {
        border-radius: 0;
        height: 100%;
    }

    .textarea-fija {
        resize: none;     
    }

    .footer_cita{
        position: absolute !important;
        bottom: 0 !important;
        width: -moz-available;
        display: flex;
        justify-content: end;
    }

    #info_sec{  
        margin-left: 15px;

    }






    .hora-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
        gap: 10px;
        margin-top: 10px;
    }

    .hora-slot {
        padding: 10px;
        text-align: center;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.2s ease;
        margin: 150px
    }

    .hora-slot:hover {
        background-color: #007bff;
        color: white;
    }

    .hora-slot.selected {
        background-color: #28a745;
        color: white;
    }
    
.car-impact-container {
position: relative;
width: 450px;
}

.img-fluid {
    width: 100%;
    height: auto;
    display: block;
}

.zona-impacto {
    position: absolute;
    transform: translate(-50%, -50%);
    background: rgba(255, 255, 255, 0.85);
    padding: 3px 4px;
    border-radius: 6px;
    font-size: 12px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 5px;
    border: 1px solid #ccc;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
    white-space: nowrap;
}

.zona-impacto:hover {
    background: lightblue;
}

.zona-impacto input[type="checkbox"] {
    transform: scale(1);
}

.modal_recogida{
        height: 90vh;
        overflow-y: auto;
    }

    #contenedorInputsImpacto {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }

    #contenedorInputsImpacto .input-group {
        flex: 1 1 45%;
        min-width: 300px; /* Asegura que no sean demasiado pequeños en pantallas pequeñas */
    }

    .input-impacto {
        margin-top: 5px;
        width: 100%;
    }

    .img-impacto{
        max-height: 45px;
        width: auto;
    }

    .tabla_impactos{
        text-align: center;
    }
    .tabla_impactos img {
        display: block;
        margin: 0 auto;
    }


    .modal-centered {
        display: flex !important;
        align-items: flex-start;
        justify-content: center;
        min-height: 100vh;
        padding-top: 10vh; /* Ajusta este valor para subir o bajar el modal */
    }

    #modalConfirmacionImagen .btn {
        min-width: 150px;
        margin: 5px;
    }

    #modalImage {
        transition: transform 0.2s ease;
        cursor: zoom-in;
        user-select: none;
    }

    .fila-otras-citas{
        cursor: pointer;
        
    }


</style>
