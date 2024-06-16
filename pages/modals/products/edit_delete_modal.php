<div class="modal fade" id="edit_<?php echo $producto['producto_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../scripts/product_manager.php" method="post">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $producto['nombre']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoría</label>
                        <select class="form-select" id="categoria_id" name="categoria_id">
                            <option  selected value="<?php echo $categoria['categoria_id']; ?>" <?php echo ($filtro_categoria == $categoria['categoria_id']) ? 'selected' : ''; ?>><?php echo $categoria['nombre']; ?></option>
                            <?php foreach ($categorias as $categoria) : ?>
                                <option value="<?php echo $categoria['categoria_id']; ?>" <?php echo ($filtro_categoria == $categoria['categoria_id']) ? 'selected' : ''; ?>><?php echo $categoria['nombre']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?php echo $producto['descripcion']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="monto" class="form-label">Monto</label>
                        <input type="number" class="form-control" id="monto" name="monto" value="<?php echo $producto['monto']; ?>" required>
                    </div>
                    <input type="hidden" id="actionType" name="action" value="editar">
                    <input type="hidden" id="producto_id" name="producto_id" value="<?php echo $producto['producto_id']; ?>">
                    <button type="submit" class="btn btn-primary">Editar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete_<?php echo $producto['producto_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Deseas eliminar el producto <?php echo $producto['nombre'] ?> con ID: <?php echo $producto['producto_id']; ?>?</p>
            </div>
            <div class="modal-footer">
                <form action="../scripts/product_manager.php" method="post">
                    <input type="hidden" id="action" name="action" value="eliminar">
                    <input type="hidden" id="producto_id" name="producto_id" value="<?php echo $producto['producto_id']; ?>">
                    <button type="submit" class="btn btn-danger">Eliminar Producto</button>
                </form>
            </div>
        </div>
    </div>
</div>

