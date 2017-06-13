<?php

namespace App\Models;

use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class User extends \Core\Model
{

    /**
     * 
     * @param type $data
     */
    public function __construct($data) {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }
    
    
    /**
     * 
     */
    public function save() {
        $password_hash = \password_hash($this->password, PASSWORD_DEFAULT);
        
        $sql = 'INSERT INTO users (name, email, password_hash)
                VALUES (:name, :email, :password_hash)';
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        
        $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
        
        $stmt->execute();
    }
    
    
    /**
     * Get all the users as an associative array
     *
     * @return array
     */
    /*public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT id, name FROM users');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }*/
    
}
