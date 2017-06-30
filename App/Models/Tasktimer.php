<?php

namespace App\Models;

use PDO;
use App\Auth;


/**
 * Tasktimers model
 *
 * PHP version 7.0
 */

class Tasktimer extends \Core\Model
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
     * Read either one or all Tasktimer entries.
     *
     * If $id = NULL then read and return all entries.
     *
     * @return boolean
     */
    public function read($id = NULL)
    {
        $sql = 'SELECT *
                FROM task_timer
                ';
        // Select only one entry
        if ($id) {
            $sql .= ' WHERE tt_id = :tt_id';
        }

        // Prepare sql and bind project id if used.
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        if ($id) {
            $stmt->bindValue(':tt_id', $id, PDO::PARAM_INT);
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
     * Read all tasks timers that mak
     * 
     * @param type $id
     * @return boolean
     */
    public function readtask($id)
    {
        $sql = 'SELECT *
                FROM task_timer 
                WHERE tt_task_id = :tt_task_id
                ';

        // Prepare sql and bind project id if used.
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        if ($id) {
            $stmt->bindValue(':tt_task_id', $id, PDO::PARAM_INT);
        }

        $stmt->execute();

        // Return all task timer entries for a task ID.
        if ($stmt) {
            return $stmt->fetchAll();
        } 
        else {
            $this->errors[] = 'The task timer fetch did not work.';
        }

        return false;
    }


    /**
     * Save the task_timer model with the current property values
     *
     * @return boolean  True if the user was saved, false otherwise
     */
    public function save()
    {
        $this->validate();

        if (empty($this->errors)) {

            $sql = 'INSERT INTO task_timer (tt_task_id, tt_user_id, tt_start_datetime, tt_duration)
                    VALUES (:tt_task_id, :tt_user_id, :tt_start_datetime, :tt_duration)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':tt_task_id', $this->tt_task_id, PDO::PARAM_INT);
            $stmt->bindValue(':tt_user_id', $this->tt_user_id, PDO::PARAM_INT);
            $stmt->bindValue(':tt_start_datetime', $this->tt_start_datetime, PDO::PARAM_STR);
            $stmt->bindValue(':tt_duration', $this->tt_duration, PDO::PARAM_INT);

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
        if (isset($this->tt_id) && ! filter_var($this->tt_id, FILTER_VALIDATE_INT)) {
            $this->errors[] = 'The task timer id is not valid';
        }
    }

// End of Tasktimer model class.
}
