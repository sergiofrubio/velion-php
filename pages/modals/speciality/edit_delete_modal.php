<!-- Modal -->
<div class="modal fade" id="edit_<?php echo $especialidad['especialidad_id']; ?>" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar especialidad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../scripts/speciality_manager.php" method="post">
                <div class="modal-body">
                    <input type="hidden" value="<?php echo $especialidad['especialidad_id']; ?>" id="especialidad_id" name="especialidad_id">
                    <label for="descipcion" class="form-label">Descripción</label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?php echo $especialidad['descripcion']; ?>">
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="actionType" name="action" value="editar">
                    <button type="submit" class="btn btn-primary">Editar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal eliminar usuario -->
<div class="modal fade" id="delete_<?php echo $especialidad['especialidad_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar especialidad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Deseas eliminar la especialidad <?php echo $especialidad['descripcion'] ?> con ID: <?php echo $especialidad['especialidad_id']; ?>?</p>
            </div>
            <div class="modal-footer">
                <form action="../scripts/speciality_manager.php" method="post">
                    <input type="hidden" id="action" name="action" value="eliminar">
                    <input type="hidden" id="especialidad_id" name="especialidad_id" value="<?php echo $especialidad['especialidad_id']; ?>">
                    <button type="submit" class="btn btn-danger">Eliminar especialidad</button>
                </form>
            </div>
        </div>
    </div>
</div>