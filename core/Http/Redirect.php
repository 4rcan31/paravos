<?php


class Redirect {
    // Redirige al usuario a una URL específica
    public static function to(string $to) {
        header("Location: $to");
        exit;
    }

    // Redirige al usuario a la página anterior
    public static function back(string $defaulRedirect = "/") {
        isset($_SERVER['HTTP_REFERER']) ? 
        header("Location: {$_SERVER['HTTP_REFERER']}") : 
        self::to($defaulRedirect);
        exit;
    }

    // Almacena datos en la sesión de forma temporal
    public static function with(string $key, $value) {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION[$key] = $value;
    }

    // Obtiene y elimina datos de la sesión que se almacenaron temporalmente
    public static function flash(string $key) {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION[$key])) {
            $value = $_SESSION[$key];
            unset($_SESSION[$key]);
            return $value;
        }
        return null;
    }
}
