<?= link_tag('/assets/css/theme-default.css') ?>
<style>
    

    .vcenter{
        display: inline-block;
        vertical-align: middle;
        float:none;
    }

    .m-auto{
        margin: auto;
    }

    /* .control-label{
        height: 50%;
        vertical-align: middle;
    } */

    
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

    #boton_vehiculos{
        border-radius: 100% ; 
        width: 30px ; 
        height: 30px ; 
        display: flex ; 
        align-items: center ; 
        justify-content: center ;
    }
    #div_botones{
        display: flex; 
        gap: 10px;
        flex-direction: column;
        align-items: center;
    }

    .table-container {
        max-height: 315px;
        overflow-y: auto;
        display: block;
    }

    /* Fijar el ancho de la tabla para que encaje */
    .table {
        width: 100%;
        border-collapse: collapse;
    }

    /* Encabezado fijo */
    .table thead {
        position: sticky;
        top: 0;
        background-color: #fff;
        z-index: 1;
    }

    .textarea-fija{
        resize: none;
    }

</style>

<style>
   .modal.slide-right .modal-dialog {
        transform: translateX(100%);
        transition: transform 0.3s ease-out;
    }

    .modal.in.slide-right .modal-dialog {
        transform: translateX(0);
    }


   .modal-dialog-slideout {
        position: fixed;
        margin: 0;
        right: 0;
        top: 0;
        bottom: 0;
        height: 100%;
        width: 400px;
        max-width: 100%;
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



</style>

