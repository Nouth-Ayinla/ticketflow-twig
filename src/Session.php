<?php

namespace TicketFlow;

class Session
{
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set($key, $value)
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    public static function get($key, $default = null)
    {
        self::start();
        return $_SESSION[$key] ?? $default;
    }

    public static function has($key)
    {
        self::start();
        return isset($_SESSION[$key]);
    }

    public static function remove($key)
    {
        self::start();
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public static function destroy()
    {
        self::start();
        session_unset();
        session_destroy();
    }

    public static function setFlash($key, $message)
    {
        self::set('flash_' . $key, $message);
    }

    public static function getFlash($key)
    {
        self::start();
        $message = self::get('flash_' . $key);
        self::remove('flash_' . $key);
        return $message;
    }

    public static function isAuthenticated()
    {
        return self::has('ticketapp_session');
    }

    public static function getUser()
    {
        return self::get('ticketapp_session');
    }

    public static function setUser($user)
    {
        self::set('ticketapp_session', $user);
    }

    public static function logout()
    {
        self::remove('ticketapp_session');
        self::remove('csrf_token');
    }

    public static function validateCSRF($token)
    {
        return hash_equals(self::get('csrf_token', ''), $token);
    }
}
