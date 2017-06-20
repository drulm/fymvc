<?php

namespace App\Models;

use PDO;
//use \App\Token;
//use \Core\View;


/**
 * Blog model
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
     * Read either one or all Blog entries.
     *
     * If $id = NULL then read and return all entries.
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

            $sql = 'INSERT INTO blog (title, post, timestamp)
                    VALUES (:title, :post, :timestamp)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
            $stmt->bindValue(':post', $this->post, PDO::PARAM_STR);
            $stmt->bindValue(':timestamp', time(), PDO::PARAM_INT);

            return $stmt->execute();
        }

        return false;
    }


    /**
     * Update a blog entry, getting id from post.
     *
     * @return boolean
     */
    public function update()
    {
        $this->validate();

        if (empty($this->errors)) {

            $sql = 'UPDATE blog SET
                    post = :post ,
                    title = :title
                    WHERE id = :id';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
            $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
            $stmt->bindValue(':post', $this->post, PDO::PARAM_STR);

            return $stmt->execute();
        }

        return false;
    }


    /**
     * Delete the entry from the database.
     *
     * @return boolean
     */
    public function delete($id)
    {
        if (filter_var($id, FILTER_VALIDATE_INT)) {
            $sql = 'DELETE FROM
                    blog WHERE id = :id';

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();
        }

        return false;
    }


    /**
     * Validate current property values, adding validation error messages to the errors array property
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
            $this->errors[] = 'A blog post is required';
        }
        if (isset($this->id) && ! filter_var($this->id, FILTER_VALIDATE_INT)) {
            $this->errors[] = 'The id is not valid';
        }
    }

// End of Blog model class.
}
