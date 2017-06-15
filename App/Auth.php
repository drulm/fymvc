<?php

namespace App;

/**
 * Authentication
 *
 * PHP version 7.0
 */
class Auth
{
    /**
     * Login the user
     *
     * @param User $user The user model
     *
     * @return void
     */
    public static function login($user)
    {
        session_regenerate_id(true);

        $_SESSION['user_id'] = $user->id;
    }

    /**
     * Logout the user
     *
     * @return void
     */
    public static function logout()
    {
      // Unset all of the session variables
      $_SESSION = [];

      // Delete the session cookie
      if (ini_get('session.use_cookies')) {
          $params = session_get_cookie_params();

          setcookie(
              session_name(),
              '',
              time() - 42000,
              $params['path'],
              $params['domain'],
              $params['secure'],
              $params['httponly']
          );
      }

      // Finally destroy the session
      session_destroy();
    }

    /**
     * Return indicator of whether a user is logged in or not
     *
     * @return boolean
     */
    public static function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }    
}