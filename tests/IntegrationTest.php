<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class IntegrationTest extends TestCase
{
    private $baseUrl;
    private $cookieFile;

    protected function setUp(): void
    {
        // Inside Docker, the app is at http://localhost
        $this->baseUrl = getenv('APP_URL') ?: 'http://localhost';
        $this->cookieFile = tempnam(sys_get_temp_dir(), 'test_cookie_');
    }

    protected function tearDown(): void
    {
        if (file_exists($this->cookieFile)) {
            unlink($this->cookieFile);
        }
    }

    private function login($email, $pass)
    {
        $ch = curl_init($this->baseUrl . '/login');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'email' => $email,
            'pass' => $pass
        ]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookieFile);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    private function get($url)
    {
        $ch = curl_init($this->baseUrl . $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieFile);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return [
            'code' => $httpCode,
            'body' => $response
        ];
    }

    private function post($url, $data)
    {
        $ch = curl_init($this->baseUrl . $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieFile);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookieFile);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return [
            'code' => $httpCode,
            'body' => $response
        ];
    }

    public function testAdminDashboard()
    {
        $this->login('admin@example.com', '12345678');
        $res = $this->get('/inicio');
        $this->assertEquals(200, $res['code']);
        $this->assertStringContainsString('Pacientes Totales', $res['body']);
        $this->assertStringContainsString('Citas Hoy', $res['body']);
    }

    public function testAdminUserList()
    {
        $this->login('admin@example.com', '12345678');
        $res = $this->get('/usuarios');
        $this->assertEquals(200, $res['code']);
        $this->assertStringContainsString('Usuarios', $res['body']);
    }

    public function testAdminCreateAppointment()
    {
        $this->login('admin@example.com', '12345678');

        $data = [
            'paciente_id' => '123456789', // Patient ID from DB
            'fisioterapeuta_id' => '234567890', // Fisio ID from DB
            'fecha_hora' => date('Y-m-d H:i', strtotime('+2 days')),
            'estado' => 'Programada',
            'especialidad_id' => '1'
        ];

        $res = $this->post('/citas/create', $data);
        
        $this->assertEquals(200, $res['code']);
        $this->assertStringContainsString('Cita programada correctamente', $res['body']);
    }

    public function testPatientTienda()
    {
        $this->login('patient@example.com', '12345678');
        $res = $this->get('/vista-pacientes/tienda');
        $this->assertEquals(200, $res['code']);
        $this->assertStringContainsString('Tienda', $res['body']);
        $this->assertStringContainsString('Bonos Disponibles', $res['body']);
    }

    public function testAdminFacturas()
    {
        $this->login('admin@example.com', '12345678');
        $res = $this->get('/facturas');
        $this->assertEquals(200, $res['code']);
        $this->assertStringContainsString('Facturas', $res['body']);
    }

    public function testUnauthorizedRedirect()
    {
        $res = $this->get('/usuarios');
        // Should show login page
        $this->assertStringContainsString('Bienvenido de nuevo', $res['body']);
        $this->assertStringContainsString('Inicia sesión en tu cuenta', $res['body']);
    }
}
