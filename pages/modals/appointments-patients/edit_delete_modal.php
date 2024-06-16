<!-- Modal eliminar cita -->
<div class="modal fade" id="delete_<?php echo $cita['cita_id']; ?>" tabindex="-1" role="dialog"
  aria-labelledby="deleteModalLabel" aria-hidden="true" style="margin-bottom: 50">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel" style="color:#FFFFFF">Eliminar cita</h5>
      </div>
      <div class="modal-body">
        <p style="color:#FFFFFF; text-align:left;">¿Deseas eliminar esta cita de
          <?php echo $cita['paciente_nombre'] . ' ' . $cita['paciente_apellidos']; ?>?
        </p>
      </div>
      <div class="modal-footer">
        <form action="../scripts/appointment_manager.php" method="post">
          <input type="hidden" name="action" id="action" value="eliminar-patient">
          <input type="hidden" name="cita_id" id="cita_id" value="<?php echo $cita['cita_id']; ?>">
          <button type="submit" class="btn btn-danger">Eliminar cita</button>
          <a href="../pages/appointments-patients.php" class="btn btn secondary">Cerrar</a>
        </form>
      </div>
    </div>
  </div>
</div>