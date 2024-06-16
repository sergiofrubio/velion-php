<!-- Modal agregar factura -->
<div class="modal fade" id="agregarModal" tabindex="-1" aria-labelledby="agregarFacturaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarFacturaModalLabel">Agregar Factura</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../scripts/invoice_manager.php" method="post">
                <div class="modal-body">
                    <input type="hidden" id="actionType" name="action" value="guardar_factura">
                    <div class="mb-3">
                        <label for="paciente_id" class="form-label">ID del Paciente</label>
                        <input type="text" class="form-control" id="paciente_id" name="paciente_id" placeholder="ID del Paciente" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_emision" class="form-label">Fecha de Emisión</label>
                        <input type="date" class="form-control" id="fecha_emision" name="fecha_emision" required>
                    </div>
                    <div class="mb-3">
                        <label for="producto" class="form-label">Producto</label>
                        <select class="form-select" id="producto_id" name="producto_id" required>
                            <option value="" hidden selected>Selecciona un producto</option>
                            <?php foreach ($productos as $producto) : ?>
                                <option value="<?php echo $producto['producto_id']; ?>"><?php echo $producto['nombre']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado" required>
                            <option value="" disabled selected>Selecciona el estado</option>
                            <option value="Pendiente">Pendiente</option>
                            <option value="Pagada">Pagada</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Factura</button>
                </div>
            </form>
        </div>
    </div>
</div>
