<div class="modal fade" id="modalNuevaTarea" tabindex="-1" role="dialog" aria-labelledby="modalNuevaTareaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formNuevaTarea" method="post" action="">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalNuevaTareaLabel">Añadir Nueva Tarea</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <input type="hidden" name="id_area_trabajo" id="m_id_area" value="">

          <div class="form-group">
            <label>Descripción</label>
            <input type="text" name="descripcion" id="m_descripcion" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Tiempo Estimado</label>
            <input type="time" name="tiempo_estimado" id="m_tiempo_estimado" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Precio Unitario (€)</label>
            <input type="number" name="precio_unitario" id="m_precio_unitario" step="0.01" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Max. Unidades</label>
            <input type="number" name="max_unidades" id="m_max_unidades" class="form-control" required>
          </div>

          <div class="form-group">
            <label>¿Externa?</label>
            <select name="externa" id="m_externa" class="form-control">
              <option value="0" selected>No</option>
              <option value="1">Sí</option>
            </select>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary guardar_tarea">Crear Tarea</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>
