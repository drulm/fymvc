<?php

namespace App;

class Flash {
    
    /**
     * 
     * @param type $message
     */
    public static function addMessage($message) {
        if (isset($_SESSION['flash_notifications'])) {
            $_SESSION['flash_notifications'] = [];
        }
        $_SESSION['flash_notifications'][] = $message; 
    }
    
    
    public static function getMessages() {
        if (isset($_SESSION['flash_notifications'])) {
            $messages =  $_SESSION['flash_notifications'];
            unset($_SESSION['flash_notifications']);
            return $messages;
        }
    }
    
}