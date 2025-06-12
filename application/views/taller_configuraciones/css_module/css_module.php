<?= link_tag('/assets/css/theme-default.css') ?>
<style>
.vcenter {
    display: inline-block;
    vertical-align: middle;
    float: none;
}

.m-auto {
    margin: auto;
}

.col_sel {
    align-items: center;
}


.imgModelo {
    max-width: 120px;
}

.divImgModelo {
    align-content: center;
    height: 120px;
    width: 120px;
}

.divImgModelo p {
    text-align: center;
    color: grey;
}

.body_img {
    overflow: hidden;
}

#modalImage {
    width: 100%;
    height: auto;
    object-fit: contain; /* Mantiene la relación de aspecto */
    cursor: zoom-in;
    transition: transform 0.25s ease;
}

#modalImage.zoomed {
    cursor: zoom-out;
}


#boton_vehiculos {
    border-radius: 100%;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
}

#div_botones {
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

.table {
    width: 100%;
    border-collapse: collapse;
}

.table thead {
    position: sticky;
    top: 0;
    background-color: #fff;
    z-index: 1;
}


.textarea-fija {
    resize: none;
}

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

.modal-content {
    border-radius: 0;
    height: 100%;
}


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


.footer_cita {
    position: absolute !important;
    bottom: 0 !important;
    width: -moz-available;
    display: flex;
    justify-content: flex-end;
}


#info_sec {
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

.modal_recogida {
    height: 96vh;
    overflow-y: auto;
}


#contenedorInputsImpacto {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

#contenedorInputsImpacto .input-group {
    flex: 1 1 45%;
    min-width: 300px;
}

.input-impacto {
    margin-top: 5px;
    width: 100%;
}

.img-impacto {
    max-height: 45px;
    width: auto;
}


.tabla_impactos {
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


#modalConfirmacionImagen .btn,
#modalConfirmacionRecepcion .btn {
    min-width: 150px;
    margin: 5px;
}


#modalImage {
    transition: transform 0.2s ease;
    cursor: zoom-in;
    user-select: none;
}


.fila-otras-citas {
    cursor: pointer;
}


@media (max-width: 767px) {
    .detalles_center_xs {
        text-align: center;
    }

    .detalles_right_xs {
        text-align: right;
    }

    .detalles_left_xs {
        text-align: left;
    }
}


.panel-body.tareas-container {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
}

.form_tareas {
    flex: 0 0 calc(25% - 10px);
    box-sizing: border-box;
}

#productos_titulo{
    color: #565656;
}

 .panel-body-tareas {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    @media (max-width: 767px) {
        .form_tareas {
            flex: 0 0 calc(100% - 10px);
            box-sizing: border-box;
        }

        .panel-body-tareas {
            gap: 0px;
        }

    }

</style>

<style>
  
.padding-md-x {
      padding-left: 200px !important;
      padding-right: 200px !important;
    }
  @media (max-width: 1000px) {
    .padding-md-x {
    padding-left: 15px !important;
    padding-right: 15px !important;
  }
  }
</style>
