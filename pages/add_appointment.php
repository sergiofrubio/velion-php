<?php include './includes/dashboard.php';?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title mb-0">Solicitud de Cita Médica</h5>
                </div>
                <div class="card-body">
                    <form action="procesar_cita.php" method="POST">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="usuario_id" name="usuario_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Fisioterapeuta</label>
                            <input type="email" class="form-control" id="fisioterapeuta_id" name="fisioterapeuta_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Especialidad</label>
                            <input type="email" class="form-control" id="especialidad_id" name="especialidad_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" class="form-date" id="fecha_hora" name="fecha_hora" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Enviar Cita</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
