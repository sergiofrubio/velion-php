<?php
use App\Routes\Router;

$router = new Router();

// Rutas Públicas (Sin autenticación)
$router->add('GET', '/landing', 'LandingController@index', false);
$router->add('GET', '/', 'LoginController@cargarVista', false);
$router->add('GET', '/login', 'LoginController@cargarVista', false);
$router->add('POST', '/login', 'LoginController@iniciarSesion', false);
$router->add('POST', '/login/reset-password', 'LoginController@generatePasswordResetToken', false);
$router->add('GET', '/logout', 'LoginController@finishSesion', false);

// Rutas Generales (Requieren autenticación, accesibles por todos los roles)
$router->add('GET', '/inicio', 'InicioController@index', true, ['Administrador', 'Fisioterapeuta', 'Paciente']);

// Rutas para Administradores y Fisioterapeutas
$staffRoles = ['Administrador', 'Fisioterapeuta'];

$router->add('GET', '/usuarios', 'UserController@list', true, $staffRoles);
$router->add('GET', '/usuarios/create', 'UserController@create', true, ['Administrador']); // Solo admin crea usuarios
$router->add('POST', '/usuarios/create', 'UserController@create', true, ['Administrador']);
$router->add('POST', '/usuarios/delete', 'UserController@delete', true, ['Administrador']);
$router->add('GET', '/usuarios/edit', 'UserController@edit', true, ['Administrador']);
$router->add('POST', '/usuarios/edit', 'UserController@edit', true, ['Administrador']);
$router->add('GET', '/usuarios/detail', 'UserController@detail', true, $staffRoles);
$router->add('GET', '/usuarios/pdf', 'UserController@createPDF', true, $staffRoles);
$router->add('POST', '/usuarios/pdf', 'UserController@createPDF', true, $staffRoles);
$router->add('POST', '/usuarios/filter', 'UserController@FindById', true, $staffRoles);
$router->add('GET', '/usuarios/search', 'UserController@search', true, $staffRoles, true);

$router->add('GET', '/citas', 'AppointmentController@list', true, $staffRoles);
$router->add('GET', '/citas/create', 'AppointmentController@create', true, $staffRoles);
$router->add('POST', '/citas/create', 'AppointmentController@create', true, $staffRoles);
$router->add('POST', '/citas/delete', 'AppointmentController@delete', true, $staffRoles);
$router->add('POST', '/citas/edit', 'AppointmentController@edit', true, $staffRoles);
$router->add('GET', '/citas/edit', 'AppointmentController@edit', true, $staffRoles);
$router->add('GET', '/citas/slots', 'AppointmentController@getSlots', true, $staffRoles);

$router->add('GET', '/configuracion', 'ConfiguracionController@index', true, ['Administrador']);
$router->add('GET', '/configuracion/horarios/create', 'ConfiguracionController@createHorario', true, ['Administrador']);
$router->add('POST', '/configuracion/horarios/create', 'ConfiguracionController@createHorario', true, ['Administrador']);
$router->add('GET', '/configuracion/horarios/edit', 'ConfiguracionController@editHorario', true, ['Administrador']);
$router->add('POST', '/configuracion/horarios/edit', 'ConfiguracionController@editHorario', true, ['Administrador']);

$router->add('GET', '/configuracion/ausencias/create', 'ConfiguracionController@createAusencia', true, ['Administrador']);
$router->add('POST', '/configuracion/ausencias/create', 'ConfiguracionController@createAusencia', true, ['Administrador']);
$router->add('GET', '/configuracion/ausencias/edit', 'ConfiguracionController@editAusencia', true, ['Administrador']);
$router->add('POST', '/configuracion/ausencias/edit', 'ConfiguracionController@editAusencia', true, ['Administrador']);

$router->add('GET', '/configuracion/especialidades/create', 'ConfiguracionController@createEspecialidad', true, ['Administrador']);
$router->add('POST', '/configuracion/especialidades/create', 'ConfiguracionController@createEspecialidad', true, ['Administrador']);
$router->add('GET', '/configuracion/especialidades/edit', 'ConfiguracionController@editEspecialidad', true, ['Administrador']);
$router->add('POST', '/configuracion/especialidades/edit', 'ConfiguracionController@editEspecialidad', true, ['Administrador']);

$router->add('GET', '/configuracion/bonos/create', 'ConfiguracionController@createBono', true, ['Administrador']);
$router->add('POST', '/configuracion/bonos/create', 'ConfiguracionController@createBono', true, ['Administrador']);
$router->add('GET', '/configuracion/bonos/edit', 'ConfiguracionController@editBono', true, ['Administrador']);
$router->add('POST', '/configuracion/bonos/edit', 'ConfiguracionController@editBono', true, ['Administrador']);

$router->add('POST', '/configuracion/clinica/update', 'ConfiguracionController@updateClinica', true, ['Administrador']);

$router->add('GET', '/historial/create', 'MedicalHistoryController@create', true, $staffRoles);
$router->add('POST', '/historial/create', 'MedicalHistoryController@create', true, $staffRoles);
$router->add('GET', '/historial/detail', 'MedicalHistoryController@detail', true, $staffRoles);
$router->add('GET', '/historial/pdf', 'MedicalHistoryController@pdf', true, $staffRoles);

$router->add('GET', '/facturas', 'FacturaController@list', true, $staffRoles);
$router->add('GET', '/facturas/create', 'FacturaController@create', true, $staffRoles);
$router->add('POST', '/facturas/create', 'FacturaController@create', true, $staffRoles);
$router->add('GET', '/facturas/edit', 'FacturaController@edit', true, $staffRoles);
$router->add('POST', '/facturas/edit', 'FacturaController@edit', true, $staffRoles);
$router->add('POST', '/facturas/delete', 'FacturaController@delete', true, $staffRoles);
$router->add('GET', '/facturas/pdf', 'FacturaController@pdf', true, $staffRoles);

// Rutas para Pacientes
$patientRole = ['Paciente'];

$router->add('GET', '/vista-pacientes/citas', 'AppointmentController@list', true, $patientRole);
$router->add('GET', '/vista-pacientes/citas/nueva', 'AppointmentController@create', true, $patientRole);
$router->add('POST', '/vista-pacientes/citas/nueva', 'AppointmentController@create', true, $patientRole);
$router->add('GET', '/vista-pacientes/citas/edit', 'AppointmentController@edit', true, $patientRole);
$router->add('POST', '/vista-pacientes/citas/edit', 'AppointmentController@edit', true, $patientRole);
$router->add('POST', '/vista-pacientes/citas/delete', 'AppointmentController@delete', true, $patientRole);

$router->add('GET', '/vista-pacientes/perfil', 'ProfileController@index', true, $patientRole);
$router->add('GET', '/vista-pacientes/perfil/edit', 'ProfileController@edit', true, $patientRole);
$router->add('POST', '/vista-pacientes/perfil/edit', 'ProfileController@edit', true, $patientRole);
$router->add('POST', '/vista-pacientes/perfil/add-payment-method', 'ProfileController@addPaymentMethod', true, $patientRole);
$router->add('GET', '/vista-pacientes/perfil/delete-payment-method', 'ProfileController@deletePaymentMethod', true, $patientRole);
$router->add('GET', '/vista-pacientes/perfil/set-primary-payment', 'ProfileController@setPrimaryPaymentMethod', true, $patientRole);

$router->add('GET', '/vista-pacientes/tienda', 'TiendaController@list', true, $patientRole);
$router->add('GET', '/vista-pacientes/tienda/pago', 'TiendaController@pago', true, $patientRole);
$router->add('POST', '/vista-pacientes/tienda/procesar-pago', 'TiendaController@procesarPago', true, $patientRole);

$router->add('GET', '/vista-pacientes/facturas', 'FacturaController@list', true, $patientRole);

$router->handleRequest();