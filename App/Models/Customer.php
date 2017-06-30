<?php

namespace App\Models;

use PDO;
use App\Auth;


/**
 * Customers model
 *
 * PHP version 7.0
 */

class Customer extends \Core\Model
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
        }
    }


    /**
     * Read either one or all Customer entries.
     *
     * If $id = NULL then read and return all entries.
     *
     * @return boolean
     */
    public function read($id = NULL)
    {
        $sql = 'SELECT *
                FROM customers
                ';
        // Select only one entry
        if ($id) {
            $sql .= ' WHERE customer_id = :customer_id';
        }

        // Prepare sql and bind project id if used.
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        if ($id) {
            $stmt->bindValue(':customer_id', $id, PDO::PARAM_INT);
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
     * Save the customer model with the current property values
     *
     * @return boolean  True if the user was saved, false otherwise
     */
    public function save()
    {
        $this->validate();

        if (empty($this->errors)) {

            $sql = 'INSERT INTO customers (customer_name)
                    VALUES (:customer_name)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':customer_name', $this->title, PDO::PARAM_STR);
            return $stmt->execute();
        }

        return false;
    }


    /**
     * Update a customer entry, getting id from POST.
     *
     * @return boolean
     */
    public function update()
    {
        $this->validate();

        if (empty($this->errors)) {

            $sql = 'UPDATE customers SET
                    customer_name = :customer_name ,
                    WHERE customer_id = :customer_id';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':customer_id', $this->customer_id, PDO::PARAM_INT);
            $stmt->bindValue(':customer_name', $this->customer_name, PDO::PARAM_STR);

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
                    customers WHERE customer_id = :customer_id';

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':customer_id', $id, PDO::PARAM_INT);

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
            $this->errors[] = 'A customer_id title is required';
        }
        if (isset($this->id) && ! filter_var($this->id, FILTER_VALIDATE_INT)) {
            $this->errors[] = 'The id is not valid';
        }
    }

// End of Customer model class.
}
