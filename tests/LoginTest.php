<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    private $baseUrl;

    protected function setUp(): void
    {
        $this->baseUrl = getenv('APP_URL') ?: 'http://localhost';
    }

    /**
     * Test a successful login with admin credentials and session persistence.
     */
    public function testLoginSuccess()
    {
        $email = 'admin@example.com';
        $pass = '12345678';
        $cookieFile = tempnam(sys_get_temp_dir(), 'cookie_');

        // Step 1: Attempt Login
        $ch = curl_init($this->baseUrl . '/login');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'email' => $email,
            'pass' => $pass
        ]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile); // Save cookies

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $this->assertEquals(302, $httpCode, "Successful login should return a 302 redirect.");
        $this->assertStringContainsString('Location: /inicio', $response, "Should redirect to /inicio on success.");

        // Step 2: Verify Access to /inicio
        $ch = curl_init($this->baseUrl . '/inicio');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile); // Send cookies
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $this->assertEquals(200, $httpCode, "Should be able to access /inicio after login.");
        // Check for some content that only exists on the dashboard/inicio page
        // For example, "Panel de Control" or "Bienvenido"
        $this->assertStringContainsString('Citas', $response, "Dashboard should contain 'Citas'.");

        if (file_exists($cookieFile)) {
            unlink($cookieFile);
        }
    }

    /**
     * Test a failed login with incorrect credentials.
     */
    public function testLoginFailure()
    {
        $email = 'wrong@example.com';
        $pass = 'wrongpassword';

        $ch = curl_init($this->baseUrl . '/login');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'email' => $email,
            'pass' => $pass
        ]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // A failed login should redirect back to /login with error message
        $this->assertEquals(302, $httpCode, "Failed login should return a 302 redirect.");
        $this->assertStringContainsString('Location: /login?alert=warning', $response, "Should redirect back to login with warning alert.");
    }

    /**
     * Test login with missing credentials.
     */
    public function testLoginMissingCredentials()
    {
        $ch = curl_init($this->baseUrl . '/login');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([])); // Empty POST
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $this->assertEquals(302, $httpCode);
        $this->assertStringContainsString('Location: /login?alert=warning&message=Faltan credenciales.', $response);
    }
}
