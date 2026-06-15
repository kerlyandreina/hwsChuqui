<?php
// =====================================================
//  callback.php
//  Paso 2 del flujo OAuth: Google redirige aquí con un
//  "code" temporal que intercambiamos por un access token.
// =====================================================

session_start();
require_once __DIR__ . '/config.php';

// -------------------------------------------------------
// PASO A: Verificar el STATE (protección anti-CSRF)
// -------------------------------------------------------
// Si el state que nos mandó Google no coincide con el que
// guardamos en sesión, alguien está intentando un ataque.
// Rechazamos la solicitud inmediatamente.
if (
    empty($_GET['state']) ||
    empty($_SESSION['oauth_state']) ||
    !hash_equals($_SESSION['oauth_state'], $_GET['state'])
) {
    unset($_SESSION['oauth_state']);
    header('Location: ../../index.php?error=oauth_state_mismatch');
    exit;
}
unset($_SESSION['oauth_state']); // Limpiamos: ya cumplió su función

// -------------------------------------------------------
// PASO B: Verificar que Google nos envió un code
// -------------------------------------------------------
if (empty($_GET['code'])) {
    header('Location: ../../index.php?error=oauth_no_code');
    exit;
}

$authCode = $_GET['code'];

// -------------------------------------------------------
// PASO C: Intercambiar el "code" por un Access Token
// -------------------------------------------------------
// El "code" es temporal (dura ~10 min). Lo enviamos a Google
// junto con nuestras credenciales y obtenemos el token real.
$tokenResponse = file_get_contents(GOOGLE_TOKEN_URL, false, stream_context_create([
    'http' => [
        'method'  => 'POST',
        'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
        'content' => http_build_query([
            'code'          => $authCode,
            'client_id'     => GOOGLE_CLIENT_ID,
            'client_secret' => GOOGLE_CLIENT_SECRET,
            'redirect_uri'  => GOOGLE_REDIRECT_URI,
            'grant_type'    => 'authorization_code',
        ]),
    ]
]));

if (!$tokenResponse) {
    header('Location: ../../index.php?error=oauth_token_failed');
    exit;
}

$tokenData = json_decode($tokenResponse, true);

if (empty($tokenData['access_token'])) {
    header('Location: ../../index.php?error=oauth_no_token');
    exit;
}

$accessToken = $tokenData['access_token'];

// -------------------------------------------------------
// PASO D: Obtener el perfil del usuario con el Access Token
// -------------------------------------------------------
// Con el token podemos pedirle a Google los datos del usuario:
// nombre, email, foto de perfil, etc.
$userResponse = file_get_contents(GOOGLE_USER_URL, false, stream_context_create([
    'http' => [
        'header' => "Authorization: Bearer {$accessToken}\r\n",
    ]
]));

if (!$userResponse) {
    header('Location: ../../index.php?error=oauth_user_failed');
    exit;
}

$userData = json_decode($userResponse, true);

if (empty($userData['email'])) {
    header('Location: ../../index.php?error=oauth_no_email');
    exit;
}

// -------------------------------------------------------
// PASO E: Crear la sesión del usuario
// -------------------------------------------------------
// El usuario está autenticado. Creamos la sesión igual que
// lo hace el login tradicional, así el resto del sistema
// funciona exactamente igual.
$_SESSION['user']         = $userData['email'];          // Email como identificador
$_SESSION['role']         = 'administrator';              // Rol asignado a usuarios de Google
$_SESSION['oauth_name']   = $userData['name']  ?? $userData['email']; // Nombre completo
$_SESSION['oauth_picture'] = $userData['picture'] ?? '';  // URL de la foto de perfil

// -------------------------------------------------------
// PASO F: Redirigir al panel de administrador
// -------------------------------------------------------
header('Location: ../../views/php/administrator.php');
exit;
