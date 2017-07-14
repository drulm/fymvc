<?php

namespace App\Models;

use PDO;
use App\Auth;


/**
 * Tasks model
 *
 * PHP version 7.0
 */

class Task extends \Core\Model
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
     * Read either one or all Task entries.
     *
     * If $id = NULL then read and return all entries.
     *
     * @return boolean
     */
    public function read($id = NULL)
    {
        $sql = 'SELECT *
                FROM tasks
                ';
        // Select only one entry
        if ($id) {
            $sql .= ' WHERE task_id = :task_id';
        }

        // Prepare sql and bind project id if used.
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        if ($id) {
            $stmt->bindValue(':task_id', $id, PDO::PARAM_INT);
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
     * Save the task model with the current property values
     *
     * @return boolean  True if the user was saved, false otherwise
     */
    public function save()
    {
        $this->validate();

        if (empty($this->errors)) {

            $sql = 'INSERT INTO tasks (task_name, task_project_id)
                    VALUES (:task_name, :task_project_id)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            
            //var_dump($this);

            $stmt->bindValue(':task_name', $this->name, PDO::PARAM_STR);
            $stmt->bindValue(':task_project_id', $this->task_project_id, PDO::PARAM_INT);

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

            $sql = 'UPDATE tasks SET
                    task_name = :task_name,
                    task_project_id = :task_project_id
                    WHERE task_id = :task_id';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':task_name', $this->task_name, PDO::PARAM_STR);
            $stmt->bindValue(':task_project_id', $this->task_project_id, PDO::PARAM_INT);

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
                    tasks WHERE task_id = :task_id';

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':task_id', $id, PDO::PARAM_INT);

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
        if (trim($this->name) == '') {
            $this->errors[] = 'A task name is required';
        }
        if (isset($this->project_id) && ! filter_var($this->id, FILTER_VALIDATE_INT)) {
            $this->errors[] = 'The project id is not valid';
        }
    }

// End of Task model class.
}
