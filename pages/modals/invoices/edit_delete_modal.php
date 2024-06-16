<!-- Modal -->
<div class="modal fade" id="confirm_<?php echo $factura['factura_id']; ?>" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">¿Confirmar pago?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../scripts/invoice_manager.php" method="post">
                <div class="modal-body">
                    <input type="hidden" value="<?php echo $factura['factura_id']; ?>" id="factura_id" name="factura_id">
                    <label for="descipcion" class="form-label">¿Seguro que quieres confirma el pago de esta factura?</label>
                    <input type="hidden" class="form-control" id="estado" name="estado" value="Pagada">
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="actionType" name="action" value="confirmar_pago">
                    <button type="submit" class="btn btn-success">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal eliminar factura -->
<div class="modal fade" id="delete_<?php echo $factura['factura_id']; ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar factura</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Deseas eliminar esta factura con ID: <?php echo $factura['factura_id']; ?>?</p>
            </div>
            <div class="modal-footer">
                <form action="../scripts/invoice_manager.php" method="post">
                    <input type="hidden" id="actionType" name="action" value="eliminar">
                    <input type="hidden" id="factura_id" name="factura_id" value="<?php echo $factura['factura_id']; ?>">
                    <button type="submit" class="btn btn-danger">Eliminar factura</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal generar factura -->
<div class="modal fade" id="generate_<?php echo $factura['factura_id']; ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Generar factura</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Deseas generar esta factura en PDF?</p>
            </div>
            <div class="modal-footer">
                <form action="../scripts/invoice_manager.php" method="post">
                    <input type="hidden" id="actionType" name="action" value="generar">
                    <input type="hidden" id="factura_id" name="factura_id" value="<?php echo $factura['factura_id']; ?>">
                    <button type="submit" class="btn btn-primary">Generar factura</button>
                </form>
            </div>
        </div>
    </div>
</div>