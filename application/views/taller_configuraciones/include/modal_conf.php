<!-- Modal Crear/Editar Configuración -->
<div class="modal fade" id="modalCrearConfiguracion" tabindex="-1" role="dialog" aria-labelledby="modalCrearConfiguracionLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="formCrearConfiguracion" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCrearConfiguracionLabel">Crear Nueva Configuración</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <div class="form-group">
          <label for="conf_hora_inicio">Hora Inicio</label>
          <input type="time" class="form-control" id="conf_hora_inicio" name="hora_inicio" required>
        </div>

        <div class="form-group">
          <label for="conf_hora_fin">Hora Fin</label>
          <input type="time" class="form-control" id="conf_hora_fin" name="hora_fin" required>
        </div>

        <div class="form-group">
          <label for="conf_duracion_intervalo">Duración del Intervalo</label>
          <input type="time" class="form-control" id="conf_duracion_intervalo" name="duracion_intervalo" required>
        </div>

        <div class="form-group">
          <label for="conf_simultaneo">Simultaneidad</label>
          <input type="number" class="form-control" id="conf_simultaneo" name="simultaneo" min="1" required>
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Guardar Configuración</button>
      </div>
    </form>
  </div>
</div>
