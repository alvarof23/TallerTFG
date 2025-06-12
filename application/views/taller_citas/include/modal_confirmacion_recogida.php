<!-- Modal Confirmación de Imagen -->
<div class="modal fade" id="modalConfirmacionRecepcion" tabindex="-1" role="dialog" aria-labelledby="modalConfirmacionRecepcionLabel" aria-hidden="true">
  <div class="modal-dialog modal-centered custom-modal-dialog" role="document">
    <div class="modal-content custom-modal-content">
      <div class="modal-header custom-modal-header">
        <h5 class="modal-title" id="modalConfirmacionRecepcionLabel">¿Qué deseas hacer con la recepción?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <p class="lead">Elige una opción:</p>
        
        <button type="button" class="btn btn-primary m-1" id="editRecepcion"
        data-id="<?= $cita->id ?>"
				data-id_cliente="<?= $cita->dni ?>"
				data-id_vehiculo="<?= $cita->id_vehiculo ?>"
				data-estado="<?= $cita->estado ?>"
				data-observaciones="<?= $cita->observaciones ?>"
				data-fecha="<?= $cita->fecha ?>"
				data-hora="<?= $cita->hora ?>"
				data-id_tarea="<?= $cita->id_tarea ?>"
        ><i class="fa-light fa-pen-to-square"></i> 
        <i class="fa fa-edit"></i> Editar</button>

        <button type="button" class="btn btn-danger m-1" id="delRecepcion">
        <i class="fa-solid fa-trash"></i> Eliminar</button>

        <button type="button" class="btn btn-default m-1" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
