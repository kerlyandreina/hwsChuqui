<?php
// =====================================================
//  google-login.php
//  Paso 1 del flujo OAuth: Redirige al login de Google
//  El usuario llega aquí al hacer clic en "Continuar con Google"
// =====================================================

session_start();
require_once __DIR__ . '/config.php';

// --- Generar STATE token (protección anti-CSRF) ---
// Es un valor aleatorio único que guardamos en la sesión.
// Cuando Google nos devuelva al callback, verificamos que
// el state coincida. Así evitamos ataques de falsificación.
$state = bin2hex(random_bytes(16));
$_SESSION['oauth_state'] = $state;

// --- Construir la URL de autorización de Google ---
// Le decimos a Google qué queremos (scopes), quiénes somos
// (client_id) y a dónde regresar (redirect_uri).
$params = http_build_query([
    'client_id'             => GOOGLE_CLIENT_ID,
    'redirect_uri'          => GOOGLE_REDIRECT_URI,
    'response_type'         => 'code',          // Pedimos un código, no el token directo
    'scope'                 => GOOGLE_SCOPES,
    'state'                 => $state,          // Estado anti-CSRF
    'access_type'           => 'online',        // No necesitamos refresh token
    'prompt'                => 'select_account' // Permite elegir cuenta en cada login
]);

// --- Redirigir al usuario a Google ---
header('Location: ' . GOOGLE_AUTH_URL . '?' . $params);
exit;
