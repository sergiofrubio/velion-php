<div class="modal fade" id="AsignarCita" tabindex="-1" aria-labelledby="agregarCitaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarCitaModalLabel">Agregar Nueva Cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../scripts/appointment_manager.php" method="post" id="agregarCitaForm">
                <div class="modal-body">
                    <input type="hidden" id="actionType" name="action" value="asignar">
                    <div class="mb-3">
                        <label for="paciente_id" class="form-label">Paciente</label>
                        <select class="form-select" name="paciente_id" id="paciente_id" required>
                            <option value="" hidden selected>Selecciona un paciente</option>
                            <?php foreach ($pacientes as $paciente) : ?>
                                <option value="<?php echo $paciente['usuario_id']; ?>"><?php echo $paciente['nombre'] . ' ' . $paciente['apellidos']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="especialidad_id" class="form-label">Especialidad</label>
                        <select class="form-select" name="especialidad_id" id="especialidad_id" required>
                            <option value="" hidden selected>Selecciona una especialidad</option>
                            <?php foreach ($especialidades as $especialidad) : ?>
                                <option value="<?php echo $especialidad['especialidad_id']; ?>"><?php echo $especialidad['especialidad_id'] . ' - ' . $especialidad['descripcion']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="fisioterapeuta_id" class="form-label">Fisioterapeuta</label>
                        <select class="form-select" name="fisioterapeuta_id" id="fisioterapeuta_id" required>
                            <option value="" hidden selected>Selecciona un fisioterapeuta</option>
                            <?php foreach ($fisioterapeutas as $fisioterapeuta) : ?>
                                <option value="<?php echo $fisioterapeuta['usuario_id']; ?>"><?php echo $fisioterapeuta['nombre'] . ' ' . $fisioterapeuta['apellidos']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_hora" class="form-label">Fecha y Hora</label>
                        <input type="datetime-local" class="form-control" id="fecha_hora" name="fecha_hora" required>
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado" required>
                            <option value="Programada">Programada</option>
                            <option value="Cancelada">Cancelada</option>
                            <option value="Realizada">Realizada</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" form="agregarCitaForm" class="btn btn-primary">Guardar Cita</button>
                </div>
            </form>
        </div>
    </div>
</div>

