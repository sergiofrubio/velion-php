<?php
require_once '../scripts/session_manager.php';
if ($rol == "Administrador" || $rol == "Fisioterapeuta") {
    header("Location: 404.php");
    exit();
}

// Obtener los parámetros de bono y precio de la URL
$bono = $_GET['bono'] ?? '';
$precio = $_GET['precio'] ?? '';
$fecha_emision = date('Y-m-d');

?>

<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="generator" content="Hugo 0.118.2">
    <title>Confirmación de compra</title>
    <link href="../assets/bootstrap-5.3/css/bootstrap.min.css" rel="stylesheet">
    <script src="../assets/bootstrap-5.3/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/bootstrap-5.3/js/color-modes.js"></script>
    <meta name="theme-color" content="#712cf9">

    <script>
        function mostrarCamposPago() {
            let metodoPago = document.querySelector('input[name="paymentMethod"]:checked').value;
            if (metodoPago === "tarjeta") {
                document.getElementById("camposTarjeta").style.display = "block";
                document.getElementById("camposTransferencia").style.display = "none";
            } else if (metodoPago === "transferencia") {
                document.getElementById("camposTransferencia").style.display = "block";
                document.getElementById("camposTarjeta").style.display = "none";
            }
        }
    </script>

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .btn-bd-primary {
            --bd-violet-bg: #712cf9;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

            --bs-btn-font-weight: 600;
            --bs-btn-color: var(--bs-white);
            --bs-btn-bg: var(--bd-violet-bg);
            --bs-btn-border-color: var(--bd-violet-bg);
            --bs-btn-hover-color: var(--bs-white);
            --bs-btn-hover-bg: #6528e0;
            --bs-btn-hover-border-color: #6528e0;
            --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
            --bs-btn-active-color: var(--bs-btn-hover-color);
            --bs-btn-active-bg: #5a23c8;
            --bs-btn-active-border-color: #5a23c8;
        }

        .bd-mode-toggle {
            z-index: 1500;
        }

        .bd-mode-toggle .dropdown-menu .active .bi {
            display: block !important;
        }

        .button-container {
            display: flex;
            gap: 10px;
        }

        .button-container .btn {
            flex: 1;
        }
    </style>


</head>

<body class="bg-body-tertiary">

    <div class="container">
        <main>
            <div class="py-5 text-center">
                <!-- <img class="d-block mx-auto mb-4" src="/docs/5.3/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
                <h2>Confirmación de compra</h2>
            </div>
            <form action="../scripts/invoice_manager.php" method="post" class="needs-validation" novalidate>
                <input type="hidden" id="actionType" name="action" value="guardar_factura">
                <div class="row g-5">
                    <div class="col-md-5 col-lg-4 order-md-last">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-primary">Tu carrito</span>
                        </h4>
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                                <div>
                                    <h6 class="my-0">Bono de <?php echo $bono; ?></h6>
                                    <!-- <small class="text-body-secondary">lorem ipsum</small> -->
                                </div>
                                <span class="text-body-secondary"><?php echo $precio; ?>€</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Total (EUR)</span>
                                <strong><?php echo $precio; ?>€</strong>
                            </li>
                        </ul>

                    </div>
                    <input type="hidden" id="paciente_id" name="paciente_id" value="<?php echo $DNI; ?>">
                    <input type="hidden" id="monto" name="monto" value="<?php echo $precio; ?>">
                    <input type="hidden" id="fecha_emision" name="fecha_emision" value="<?php echo $fecha_emision; ?>">
                    <input type="hidden" id="descripcion" name="descripcion" value="Bono de <?php echo $bono; ?>">
                    <input type="hidden" id="estado" name="estado" value="pagada">
                    <div class="col-md-7 col-lg-8">
                        <h4 class="mb-3">Dirección de facturación</h4>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label for="firstName" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre"
                                    value="<?php echo $nombre ?>" disabled>
                            </div>

                            <div class="col-sm-6">
                                <label for="lastName" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" id="apellidos" name="apellidos"
                                    value="<?php echo $apellidos ?>" disabled>
                            </div>

                            <div class="col-12">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?php echo $correo ?>" disabled>
                            </div>

                            <div class="col-12">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion"
                                    value="<?php echo $direccion ?>" disabled>
                            </div>

                            <div class="col-md-5">
                                <label for="state" class="form-label">Provincia</label>
                                <input type="text" class="form-control" id="provincia" value="<?php echo $provincia ?>"
                                    disabled>
                            </div>

                            <div class="col-md-4">
                                <label for="state" class="form-label">Municipicio</label>
                                <input type="text" class="form-control" id="municipio" value="<?php echo $municipio ?>"
                                    disabled>
                            </div>

                            <div class="col-md-3">
                                <label for="zip" class="form-label">CP</label>
                                <input type="text" class="form-control" id="cp" name="cp" value="<?php echo $cp ?>"
                                    disabled>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="container mt-5">
                            <h4 class="mb-3">Método de pago</h4>

                            <div class="my-3">
                                <div class="form-check">
                                    <input id="credit" name="paymentMethod" type="radio" class="form-check-input"
                                        value="tarjeta" onclick="mostrarCamposPago()" checked required>
                                    <label class="form-check-label" for="credit">Tarjeta</label>
                                </div>
                                <div class="form-check">
                                    <input id="debit" name="paymentMethod" type="radio" class="form-check-input"
                                        value="transferencia" onclick="mostrarCamposPago()" required>
                                    <label class="form-check-label" for="debit">Transferencia</label>
                                </div>
                            </div>

                            <!-- Campos de Tarjeta de Crédito -->
                            <div id="camposTarjeta" style="display: block;">
                                <div class="mb-3">
                                    <label for="numTarjeta" class="form-label">Número de Tarjeta</label>
                                    <input type="text" class="form-control" id="numTarjeta" name="numTarjeta">
                                </div>
                                <div class="mb-3">
                                    <label for="titularTarjeta" class="form-label">Titular de la Tarjeta</label>
                                    <input type="text" class="form-control" id="titularTarjeta" name="titularTarjeta">
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="expiracionTarjeta" class="form-label">Fecha de Expiración</label>
                                        <input type="text" class="form-control" id="expiracionTarjeta"
                                            name="expiracionTarjeta" placeholder="MM/AA">
                                    </div>
                                    <div class="col">
                                        <label for="cvvTarjeta" class="form-label">CVV</label>
                                        <input type="text" class="form-control" id="cvvTarjeta" name="cvvTarjeta">
                                    </div>
                                </div>
                            </div>

                            <!-- Campos de Transferencia -->
                            <div id="camposTransferencia" style="display: none;">
                                <div class="mb-3">
                                    <label for="numCuenta" class="form-label">Número de Cuenta</label>
                                    <input type="text" class="form-control" id="numCuenta" name="numCuenta">
                                </div>
                                <div class="mb-3">
                                    <label for="nombreBeneficiario" class="form-label">Nombre del Beneficiario</label>
                                    <input type="text" class="form-control" id="nombreBeneficiario"
                                        name="nombreBeneficiario">
                                </div>
                                <!-- Otros campos relacionados con la transferencia -->
                            </div>

                        </div>

                        <hr class="my-4">

                        <div class="button-container">
                            <button class="w-100 btn btn-primary btn-lg" type="submit">Pagar</button>
                            <a class="w-100 btn btn-secondary btn-lg" href="shop.php">Cancelar</a>
                        </div>
                    </div>
            </form>
        </main>

        <footer class="my-5 pt-5 text-body-secondary text-center text-small">
            <p class="mb-1">&copy; 2024 Zero 2 Valhalla' Labs</p>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#">Privacidad</a></li>
                <li class="list-inline-item"><a href="#">Terminos</a></li>
                <li class="list-inline-item"><a href="#">Soporte</a></li>
            </ul>
        </footer>
    </div>
</body>

</html>