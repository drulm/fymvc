<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Flash;

class Test extends \Core\Controller {
    
    public function oneAction() {
        View::renderTemplate('Test/one.html');
    }
    
    public function twoAction() {
        View::renderTemplate('Test/two.html');
    }
    
}