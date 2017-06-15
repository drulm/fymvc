<?php

namespace App;

class Flash {
    
    public static function addMessage($message) {
        if (isset($_SESSION['flash_notifications'])) {
            $_SESSION['flash_notifications'] = [];
        }
        $_SESSION['flash_notifications'][] = $message; 
    }
    
    
}