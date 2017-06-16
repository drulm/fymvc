<?php

namespace App\Controllers;

use \Core\View;

class Test extends \Core\Controller {
    
    public function oneAction() {
        echo "inside controller action one";
    }
    
    public function twoAction() {
         echo "inside controller action two";
    }
    
}