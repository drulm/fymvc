<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;

/**
 * Items controller (example)
 *
 * PHP version 7.0
 */
class Items extends \Core\Controller
{

    /**
     * Items index
     *
     * @return void
     */
    public function indexAction()
    {
        $this->requireLogin();

        View::renderTemplate('Items/index.html');
    }
}