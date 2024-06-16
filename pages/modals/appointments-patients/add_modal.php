<div class="modal fade" id="AsignarCita" tabindex="-1" aria-labelledby="agregarCitaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarCitaModalLabel">Agregar Nueva Cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../scripts/appointment_manager.php" method="post" id="agregarCitaForm">
                <div class="modal-body">
                    <input type="hidden" id="actionType" name="action" value="agregarPendiente">
                    <input type="hidden" id="paciente_id" name="paciente_id" value="<?php echo $DNI?>">
                    <input type="hidden" id="fisioterapeuta_id" name="fisioterapeuta_id" value="000000000">
                    <input type="hidden" id="estado" name="estado" value="Pendiente">
                    <div class="mb-3">  
                        <label for="especialidad_id" class="form-label">Especialidad</label>
                        <select class="form-select" name="especialidad_id" id="especialidad_id" required>
                            <option value="" hidden selected>Selecciona una especialidad</option>
                            <?php foreach ($especialidades as $especialidad) : ?>
                                <option value="<?php echo $especialidad['especialidad_id']; ?>"><?php echo $especialidad['especialidad_id'] . ' - ' . $especialidad['descripcion']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" form="agregarCitaForm" class="btn btn-light">Guardar Cita</button>
                </div>
            </form>
        </div>
    </div>
</div>