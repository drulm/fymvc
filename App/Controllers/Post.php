<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Flash;
use \App\Models\Blog;


/**
 * Post (blog) controller / uses Blog model.
 *
 * PHP version 7.0
 */
class Post extends Authenticated {

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
     * Show a single blog entry.
     *
     * @return void
     */
    public function showAction() {
        $blog = new Blog();

        $results = $blog->read($this->getID());

        // If not found, show warning.
        if (!$results) {
            Flash::addMessage('Could not load blog item(s)', Flash::WARNING);
        }

        View::renderTemplate('Post/show.html', [
            'blog' => $results
        ]);
    }


    /**
     * Index of the blog entries displayed
     *
     * @return void
     */
    public function indexAction() {
        $blog = new Blog();

        if (!$results = $blog->read()) {
            Flash::addMessage('No blog posts exist', Flash::INFO);
        }
        View::renderTemplate('Post/index.html', [
            'blog' => $results
        ]);
    }


    /**
     * Edit / update a blog post.
     *
     * return @void
     */
    public function editAction() {
        // Only allow this for logged in users.
        parent::before();
        $this->user = Auth::getUser();

        $blog = new Blog();

        // Read one post at ID
        $results = $blog->read($this->getID());

       // Only allow this for logged in users who own this content.
       // parent::before($results['user_id']);
       // $this->user = Auth::getUser();

        // If not found, show warning.
        if (!$results) {
            Flash::addMessage('Could not load blog item to edit', Flash::WARNING);
            $this->redirect('/post/index');
        }

        View::renderTemplate('Post/edit.html', [
            'blog' => $results
        ]);
    }


    /**
     * Update the blog to the database
     *
     * @return void
     */
    public function updateAction() {
        // Only allow this for logged in users.
        parent::before();
        $this->user = Auth::getUser();

        $blog = new Blog(filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING));

        // Read one post at ID to check user id.
        //$results = $blog->read($this->getID());

        // Only allow this for logged in users who own this content.
        //parent::before($results['user_id']);
        //$this->user = Auth::getUser();

        if ($blog->update()) {
            Flash::addMessage('Post updated', Flash::SUCCESS);
            $this->redirect('/post/show/' . $blog->id);
        } else {
            Flash::addMessage('Could not update post with blank entries', Flash::WARNING);
            $this->redirect('/post/edit/' . $blog->id);
        }
    }


    /**
     * Delete a blog post by ID.
     *
     * return @void
     */
    public function removeAction() {
        // Only allow this for logged in users.
        parent::before();
        $this->user = Auth::getUser();

        $blog = new Blog();

        // Read one post at ID
        $results = $blog->delete($this->getID());

        if ($results) {
            Flash::addMessage('Blog post deleted', Flash::INFO);
            $this->redirect('/post/index');
        }

        // If not found, show warning.
        Flash::addMessage('Could not delete that post', Flash::INFO);
        $this->redirect('/post/show/' . $post_id);
    }


    /**
     * Show a single blog entry.
     *
     * @return void
     */
    public function deleteAction() {

        $blog = new Blog();

        // Read one post at ID to check user id.
        $results = $blog->read($this->getID());

        // Only allow this for logged in users who own this content.
        parent::before($results['user_id']);
        $this->user = Auth::getUser();

        // If not found, show warning.
        if (!$results) {
            Flash::addMessage('Could not load blog item(s)', Flash::WARNING);
        }

        Flash::addMessage('Are you sure you want to delete this blog post?', Flash::WARNING);

        View::renderTemplate('Post/delete.html', [
                'blog' => $results
            ]);
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

        View::renderTemplate('Post/new.html');
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

        $blog = new Blog(filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING));

        if ($blog->save()) {
            Flash::addMessage('New post added', Flash::SUCCESS);
            $this->redirect('/post/index');
        } else {
            Flash::addMessage('Could not add post with blank entries', Flash::WARNING);
            View::renderTemplate('Post/new.html', [
                'blog' => $blog
            ]);
        }
    }

// End of post class.
}
