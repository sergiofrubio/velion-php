<?php
require_once '../scripts/session_manager.php';
if ($rol == "Administrador" || $rol == "Fisioterapeuta") {
    header("Location: 404.php");
    exit();
}
include_once './includes/dashboard-patients.php';
?>

<svg xmlns="http://www.w3.org/2000/svg" class="d-none">
    <symbol id="check" viewBox="0 0 16 16">
        <title>Check</title>
        <path
            d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
    </symbol>
</svg>

<div class="container py-3">
    <header>
        <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
            <h1 class="display-4 fw-normal text-body-emphasis">Bonos de sesiones</h1>
        </div>
    </header>


    <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
        <div class="col">
            <div class="card mb-4 rounded-3 shadow-sm custom-bg-color">
                <div class="card-header py-3">
                    <h4 class="my-0 fw-normal">Sesión individual</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">35€</h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li></li>
                        <br>
                    </ul>
                    <button type="button" id="bono3" class="w-100 btn btn-lg btn-outline-light buy">Haz click aquí
                        para comprar</button>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card mb-4 rounded-3 shadow-sm custom-bg-color">
                <div class="card-header py-3">
                    <h4 class="my-0 fw-normal">10 sesiones</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">300€</h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>(30€/sesión)</li>
                    </ul>
                    <button type="button" id="bono1" class="w-100 btn btn-lg btn-outline-light buy">Haz click aquí
                        para comprar</button>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card mb-4 rounded-3 shadow-sm custom-bg-color">
                <div class="card-header py-3">
                    <h4 class="my-0 fw-normal">15 sesiones</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">390€</h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>(26€/sesión)</li>
                    </ul>
                    <button type="button" id="bono2" class="w-100 btn btn-lg btn-outline-light buy">Haz click aquí
                        para comprar</button>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card mb-4 rounded-3 shadow-sm custom-bg-color">
                <div class="card-header py-3">
                    <h4 class="my-0 fw-normal">20 sesiones</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">480€</h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>(24€/sesión)</li>
                    </ul>
                    <button type="button" id="bono3" class="w-100 btn btn-lg btn-outline-light buy">Haz click aquí
                        para comprar</button>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card mb-4 rounded-3 shadow-sm custom-bg-color">
                <div class="card-header py-3">
                    <h4 class="my-0 fw-normal">30 sesiones</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">615€</h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>(20,5€/sesión)</li>
                    </ul>
                    <button type="button" id="bono3" class="w-100 btn btn-lg btn-outline-light buy">Haz click aquí
                        para comprar</button>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card mb-4 rounded-3 shadow-sm custom-bg-color">
                <div class="card-header py-3">
                    <h4 class="my-0 fw-normal">Especial 10 sesiones</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">370€</h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>(37€/sesión)</li>
                    </ul>
                    <button type="button" id="bono3" class="w-100 btn btn-lg btn-outline-light buy">Haz click aquí
                        para comprar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="accordion" id="accordionExample">
        <div class="accordion-item custom-bg-color">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed custom-btn" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false"
                    aria-controls="collapseOne">
                    Consulte aquí las condiciones de compra
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <h3>Condiciones para la Compra de Bonos de Citas</h3>

                    <p>Por favor, lea detenidamente las siguientes condiciones antes de comprar un bono de citas en
                        nuestra clínica de fisioterapia:</p>

                    <p><strong>1. Uso de los Bonos de Citas</strong></p>
                    <p>Los bonos de citas adquiridos pueden ser utilizados únicamente para programar sesiones de
                        fisioterapia en nuestra clínica. No son transferibles y no pueden ser canjeados por dinero en
                        efectivo.</p>

                    <p><strong>2. Validez</strong></p>
                    <p>Los bonos de citas tienen una fecha de vencimiento específica. Es responsabilidad del cliente
                        utilizar los bonos antes de la fecha de expiración. No se otorgarán reembolsos ni se extenderá
                        la validez de los bonos vencidos.</p>

                    <p><strong>3. Reserva de Citas</strong></p>
                    <p>La reserva de citas utilizando bonos está sujeta a disponibilidad. Se recomienda programar las
                        citas con anticipación para garantizar la disponibilidad de horarios.</p>

                    <p><strong>4. Cancelaciones y Reagendamientos</strong></p>
                    <p>Las cancelaciones y reagendamientos de citas deben realizarse con al menos 24 horas de
                        anticipación. Las citas canceladas o reagendadas con menos de 24 horas de anticipación pueden
                        estar sujetas a cargos adicionales o la pérdida del bono correspondiente.</p>

                    <p><strong>5. No Show</strong></p>
                    <p>Los clientes que no se presenten a una cita sin previo aviso serán considerados como "no show".
                        Los "no show" pueden resultar en la pérdida del bono correspondiente y la necesidad de adquirir
                        un nuevo bono para programar futuras citas.</p>

                    <p>Al comprar un bono de citas en nuestra clínica de fisioterapia, usted acepta cumplir con estas
                        condiciones.</p>

                    <p>Si tiene alguna pregunta o inquietud sobre estas condiciones, no dude en ponerse en contacto con
                        nosotros.</p>
                </div>
            </div>
        </div>
    </div>

</div>

</div>

<script>
    $(document).ready(function () {
        $('.buy').on('click', function () {
            var bono = $(this).closest('.card').find('h4').text();
            var precioText = $(this).closest('.card').find('.card-title').text();

            // Extraer solo el número del precio sin el símbolo del euro
            var precio = parseFloat(precioText.replace(/[^\d.]/g, ''));

            // Redirigir a la página de confirmación de compra con los parámetros de bono y precio
            window.location.href = 'checkout.php?bono=' + encodeURIComponent(bono) + '&precio=' + encodeURIComponent(precio);
        });
    });
</script>

</body>

</html>