<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Flash;
use \App\Models\Task;
use \App\Models\Tasktimer;

/**
 * Tasks controller / uses Task model.
 *
 * PHP version 7.0
 */
class Tasks extends Authenticated {

    /**
     * Before filter - called before each action method
     *
     * @return void
     */
    protected function before($userContentId = NULL) {
        // Add any before actions here.
    }


    /**
     * Get, sanitize and return the current route id.
     *
     * @return type string
     */
    public function getID() {
        // Get the ID number
        return filter_var($this->route_params['id'], FILTER_VALIDATE_INT);
    }


    /**
     * Authenticate the customer
     *
     * @return mixed
     */
    /* public function authCustomer($customer_id) {

        $customer = new Customer();

        // Read one post at ID
        $results = $customer->read($customer_id);

        // Only allow this for logged in users who own this content.
        parent::before($results['user_id']);
        $this->user = Auth::getUser();

        return $results;
    }
     */


    /**
     * Show a single customer entry.
     *
     * @return void
     */
    public function showAction() {
        $task = new Task();

        $results = $task->read($this->getID());
        
        //var_dump($results['task_id']);
        
        $task_timer = new Tasktimer();
        
        $task_results = $task_timer->readtask($results['task_id']);
        
        //var_dump($task_results);

        // If not found, show warning.
        if (!$results) {
            Flash::addMessage('Could not load Task item(s)', Flash::WARNING);
        }

        View::renderTemplate('Tasks/show.html', [
            'task' => $results,
            'task_timer' => $task_results
        ]);
    }


    /**
     * Index of the task entries displayed
     *
     * @return void
     */
    public function indexAction() {
       $task = new Task();

        if (!$results = $task->read()) {
            Flash::addMessage('No task posts exist', Flash::INFO);
        }
        View::renderTemplate('Tasks/index.html', [
            'task' => $results
        ]);

    }


    /**
     * Edit / update a task post.
     *
     * return @void
     */
    public function editAction() {

        // Only allow this for logged in users who own this content.
        // $results = $this->authCustomer($this->getID());

        // If not found, show warning.
        if (!$results) {
            Flash::addMessage('Could not load task item to edit', Flash::WARNING);
            $this->redirect('/tasks/index');
        }

        View::renderTemplate('tasks/edit.html', [
            'task' => $results
        ]);
    }


    /**
     * Update the task to the database
     *
     * @return void
     */
    public function updateAction() {

        $task = new Task(filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING));

        // Only allow this for logged in users who own this content.
        // $results = $this->authCustomer($customer->user_id);

        if ($task->update()) {
            Flash::addMessage('Task updated', Flash::SUCCESS);
            $this->redirect('/tasks/show/' . $task->task_id);
        } else {
            Flash::addMessage('Could not update task with blank entries', Flash::WARNING);
            $this->redirect('/tasks/edit/' . $task->task_id);
        }
    }


    /**
     * Action to show verification screen for Delete.
     *
     * @return void
     */
    public function deleteAction() {

        // Only allow this for logged in users who own this content.
        // $results = $this->authCustomer($this->getID());

        // If not found, show warning.
        if (!$results) {
            Flash::addMessage('Could not delete task item(s)', Flash::WARNING);
        }

        Flash::addMessage('Are you sure you want to delete this Task?', Flash::WARNING);

        View::renderTemplate('tasks/delete.html', [
                'task' => $results
            ]);
    }


    /**
     * Delete a blog post by ID and remove it from the database.
     *
     * return @void
     */
    public function removeAction() {

        // Only allow this for logged in users who own this content.
        // $results_auth_blog = $this->authCustomer($this->getID());

        $task = new Blog();
        // Delete task at ID
        $delete_results = $blog->delete($this->getID());

        if ($delete_results) {
            Flash::addMessage('Task deleted', Flash::INFO);
            $this->redirect('/tasks/index');
        }

        // If not found, show warning.
        Flash::addMessage('Could not delete the Task', Flash::INFO);
        $this->redirect('/tasks/show/' . $this->getID());
    }


    /**
     * New blog post entry, render the form template.
     * Post/new.html will call createAction.
     *
     * return @void
     */
    public function newAction() {
        // Only allow this for logged in users.
        parent::before();
        $this->user = Auth::getUser();

        View::renderTemplate('Tasks/new.html');
    }


    /**
     * Create a new blog post entry in the DB.
     *
     * return @void
     */
    public function createAction() {
        // Only allow this for logged in users.
        parent::before();
        $this->user = Auth::getUser();

        $task = new task(filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING));
        
        //var_dump($task);

        if ($task->save()) {
            Flash::addMessage('New task added', Flash::SUCCESS);
            $this->redirect('/tasks/index');
        } else {
            Flash::addMessage('Could not add task with blank entries', Flash::WARNING);
            View::renderTemplate('tasks/new.html', [
                'task' => $task
            ]);
        }
    }

// End of tasks class.
}
