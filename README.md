# Proyecto ERP para Gestión de Citas de Clínica

Este proyecto consiste en un Sistema de Gestión de Recursos Empresariales (ERP) desarrollado para la gestión eficiente de citas en una clínica médica. Proporciona una interfaz de usuario intuitiva y funcionalidades completas para administrar citas de pacientes, médicos y recursos de la clínica.

## El proyecto utiliza las siguientes tecnologías y herramientas:

1. HTML5
2. CSS3
3. JavaScript
4. jQuery
5. Bootstrap v5.3
6. PHP
7. PHPUnit
8. Librería externa: FPDF (para la generación de documentos PDF)
9. PHPMailer

## Características Principales

1. Registro y gestión de usuarios, pacientes y sanitarios.
2. Programación y gestión de citas médicas.
3. Gestión de historial clínico.
4. Facturación y compras.
5. Generación de informes PDF.

## Instalación y Configuración

1. Clona este repositorio a tu máquina local.

2. Instala Docker en tu dispositivo.

3. Ejecuta  ``` sudo docker compose up --build  ``` en la terminal SOLO la primera vez. Para el resto: ``` sudo docker compose up  ```.

4. Abre tu navegador y ve a la dirección http://localhost:8080/ para importar la base de datos alojada en models/velion.sql

5. Inicia sesión con el usuario administrador: admin@example.com - 12345678

Para ejecutar las pruebas unitarias debes ejecutar el siguiente comando  ``` sudo vendor/bin/phpunit tests/NombreDelArchivoTest.php ```