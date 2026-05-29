<?php

function loadEnv(string $path): void
{
    if (!file_exists($path)) {
        return; 
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        // Ignorar comentarios (#) y líneas vacías
        if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) {
            continue;
        }

        // Separar clave y valor en el primer "="
        [$key, $value] = explode('=', $line, 2);
        $key   = trim($key);
        $value = trim($value);

        // Registrar como variable de entorno solo si no existe ya
        if (!getenv($key)) {
            putenv("{$key}={$value}");
            $_ENV[$key] = $value;
        }
    }
}

// Cargar el .env desde la raíz del proyecto
loadEnv(__DIR__ . '/../.env');

// -------------------------------------------------------
// Definir las constantes a partir de las variables de entorno
// -------------------------------------------------------
define('GOOGLE_CLIENT_ID',     getenv('GOOGLE_CLIENT_ID')     ?: '');
define('GOOGLE_CLIENT_SECRET', getenv('GOOGLE_CLIENT_SECRET') ?: '');
define('GOOGLE_REDIRECT_URI',  getenv('GOOGLE_REDIRECT_URI')  ?: '');

// Scopes: solo pedimos nombre, email y foto de perfil
define('GOOGLE_SCOPES', 'openid email profile');

// URL base de Google OAuth 2.0
define('GOOGLE_AUTH_URL',  'https://accounts.google.com/o/oauth2/v2/auth');
define('GOOGLE_TOKEN_URL', 'https://oauth2.googleapis.com/token');
define('GOOGLE_USER_URL',  'https://www.googleapis.com/oauth2/v3/userinfo');

