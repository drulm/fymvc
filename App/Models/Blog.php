<?php

namespace App\Models;

use PDO;
use \App\Token;
use \Core\View;

/**
 * User model
 *
 * PHP version 7.0
 */
class Blog extends \Core\Model
{

    /**
     * Error messages
     *
     * @var array
     */
    public $errors = [];

    /**
     * Class constructor
     *
     * @param array $data  Initial property values (optional)
     *
     * @return void
     */
    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }
    
    
    /**
     * Read either one or all Blog entries
     * 
     * @return boolean
     */
    public function read($id = NULL)
    {    
        $sql = 'SELECT * FROM blog ';
        // Select only one entry
        if ($id) {
            $sql .= 'WHERE id = :id ';
        }

        // Prepare sql and bind blog id if used.
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        if ($id) {
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        }
        $stmt->execute();

        // Return all or one entry depending on if id was passed.
        if ($stmt) {
            if ($id) {
                $fetch = $stmt->fetch(PDO::FETCH_ASSOC);
                return is_array($fetch) ? $fetch : false;
            }
            return $stmt->fetchAll();
        }
        
        return false;
    }


    /**
     * Save the user model with the current property values
     *
     * @return boolean  True if the user was saved, false otherwise
     */
    public function save()
    {
        $this->validate();
        
        if (empty($this->errors)) {
            $sql = 'INSERT INTO blog (title, post, user_id, timestamp)
                    VALUES (:title, :post, :user_id, :timestamp)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
            $stmt->bindValue(':post', $this->post, PDO::PARAM_STR);
            $stmt->bindValue(':user_id', 1, PDO::PARAM_INT);
            $stmt->bindValue(':timestamp', time(), PDO::PARAM_INT);

            return $stmt->execute();
        }
        
        return false;
    }


    /**
     * Update the user's profile
     *
     * @param array $data Data from the edit profile form
     *
     * @return boolean  True if the data was updated, false otherwise
     */
    public function update($data)
    {
        echo "in modelUpdate";
        return false;
    }
    
    
    /**
     * Validate current property values, adding valiation error messages to the errors array property
     *
     * @return void
     */
    public function validate()
    {
        // Check for title
        if (trim($this->title) == '') {
            $this->errors[] = 'A title is required';
        }
        if (trim($this->post) == '') {
            $this->errors[] = 'A title is required';
        }
    }
    
    
}
