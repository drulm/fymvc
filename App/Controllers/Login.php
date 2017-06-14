<?php

namespace App\Controllers;

use \Core\View;


class Login extends \Core\Controller {
    
    public function newAction() {
        View::renderTemplate('Login/new.html');
    }
}