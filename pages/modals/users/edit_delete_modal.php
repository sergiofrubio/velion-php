<!-- Modal editar usuario -->
<div class="modal fade" id="edit_<?php echo $usuario['usuario_id']; ?>" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../scripts/user_manager.php" method="post">
                <div class="modal-body">
                    <input type="hidden" id="actionType" name="action" value="editar_usuario">
                    <div id="userDetails">
                        <!-- Nombre y Apellidos -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="username" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre"
                                    value="<?php echo $usuario['nombre']; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="lastname" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" id="apellidos" name="apellidos"
                                    value="<?php echo $usuario['apellidos']; ?>" required>
                            </div>
                        </div>

                        <!-- DNI y Género -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="dni" class="form-label">DNI</label>
                                <input type="text" class="form-control" id="dni" name="usuario_id"
                                    value="<?php echo $usuario['usuario_id']; ?>" pattern="\d{8}[A-Za-z]"
                                    title="Introduce un DNI válido (8 dígitos seguidos de una letra)" required>
                            </div>
                            <div class="col-md-6">
                                <label for="genero" class="form-label">Género</label>
                                <select class="form-select" id="genero" name="genero" aria-label="Selecciona tu género">
                                    <option value="" disabled>Selecciona tu género</option>
                                    <option value="Hombre" <?php if ($usuario['genero'] === 'Hombre')
                                        echo 'selected'; ?>>
                                        Hombre</option>
                                    <option value="Mujer" <?php if ($usuario['genero'] === 'Mujer')
                                        echo 'selected'; ?>>
                                        Mujer</option>
                                    <option value="Otro" <?php if ($usuario['genero'] === 'Otro')
                                        echo 'selected'; ?>>Otro
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Rol, Fecha de nacimiento -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="rol" class="form-label">Rol</label>
                                <select class="form-select" id="rol" name="rol" aria-label="Selecciona tu rol"
                                    onchange="mostrarEspecialidad(this)">
                                    <option disabled>Selecciona un rol</option>
                                    <option value="Administrador" <?php if ($usuario['rol'] === 'Administrador')
                                        echo 'selected'; ?>>Administrador</option>
                                    <option value="Paciente" <?php if ($usuario['rol'] === 'Paciente')
                                        echo 'selected'; ?>>Paciente</option>
                                    <option value="Fisioterapeuta" <?php if ($usuario['rol'] === 'Fisioterapeuta')
                                        echo 'selected'; ?>>Fisioterapeuta</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento"
                                    value="<?php echo $usuario['fecha_nacimiento']; ?>" required>
                            </div>
                        </div>

                        <!-- Especialidad (visible solo si el rol es Fisioterapeuta) -->
                        <div class="mb-3" id="especialidad-container" <?php echo ($usuario['rol'] === 'Fisioterapeuta' || $usuario['rol'] === 'Administrador') ? 'style="display: block;"' : 'style="display: none;"'; ?>>
                            <label for="especialidad" class="form-label">Especialidad</label>
                            <input class="form-control" list="datalistOptions" id="exampleDataList"
                                value="<?php echo $usuario['especialidad']; ?>"
                                placeholder="Escribe aquí para buscar...">
                            <datalist id="datalistOptions">
                                <?php foreach ($especialidades as $especialidad): ?>
                                    <option value="<?php echo $especialidad['especialidad_id']; ?>">
                                        <?php echo $especialidad['especialidad_id'] . ' - ' . $especialidad['descripcion']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </datalist>
                        </div>

                        <!-- Sesiones disponibles -->
                        <div class="mb-3" id="sesiones-container" <?php echo ($usuario['rol'] === 'Paciente') ? 'style="display: block;"' : 'style="display: none;"'; ?>>
                            <label for="lastname" class="form-label">Sesiones disponibles</label>
                            <input type="text" value="<?php echo $usuario['sesiones_disponibles']; ?>"
                                class="form-control" id="sesiones_disponibles" name="sesiones_disponibles" required>
                        </div>

                        <!-- Telefono, Dirección -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono"
                                    value="<?php echo $usuario['telefono']; ?>" pattern="\d{8}[0-9]"
                                    title="Introduce un telefono válido, sin espacios (9 dígitos)" required>
                            </div>
                            <div class="col-md-6">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion"
                                    value="<?php echo $usuario['direccion']; ?>" required>
                            </div>
                        </div>

                        <!-- Correo electrónico, Contraseña, Provincia, Municipio y Código Postal -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?php echo $usuario['email']; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="pass" name="pass" minlength="8"
                                    name="pass" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="provincia" class="form-label">Provincia</label>
                                <input type="text" class="form-control" id="provincia" name="provincia"
                                    value="<?php echo $usuario['provincia']; ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="municipio" class="form-label">Municipio</label>
                                <input type="text" class="form-control" id="municipio" name="municipio"
                                    value="<?php echo $usuario['municipio']; ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="cp" class="form-label">Código Postal</label>
                                <input type="text" class="form-control" id="cp" name="cp"
                                    value="<?php echo $usuario['cp']; ?>" pattern="[0-9]{5}"
                                    title="Introduce un código postal válido (5 dígitos)" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal eliminar usuario -->
<div class="modal fade" id="delete_<?php echo $usuario['usuario_id']; ?>" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Deseas eliminar el usuario <?php echo $usuario['nombre'] . ' ' . $usuario['apellidos']; ?> con ID:
                    <?php echo $usuario['usuario_id']; ?>?</p>
            </div>
            <div class="modal-footer">
                <form action="../scripts/user_manager.php" method="post">
                    <input type="hidden" id="action" name="action" value="eliminar_usuario">
                    <input type="hidden" id="usuario_id" name="usuario_id"
                        value="<?php echo $usuario['usuario_id']; ?>">
                    <button type="submit" class="btn btn-danger">Eliminar usuario</button>
                </form>
            </div>
        </div>
    </div>
</div>