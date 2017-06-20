<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Flash;
use \App\Models\Blog;


/**
 * Blog controller
 *
 * PHP version 7.0
 */
class Post extends Authenticated
{
    
    /**
     * Before filter - called before each action method
     *
     * @return void
     */
    protected function before()
    {
        parent::before();
        
        $this->user = Auth::getUser();
    }

    
    /**
     * Show a single blog entry.
     *
     * @return void
     */
    public function showAction()
    {   
        $blog = new Blog();
        
        // Get the ID number
        $post_id = filter_var($this->route_params['id'], FILTER_VALIDATE_INT);
        
        // Read one post at ID
        $results = $blog->read($post_id);

        // If not found, show warning.
        if (!$results) {
            Flash::addMessage('Could not load blog item(s)', Flash::WARNING);
        }
        
        View::renderTemplate('Post/show.html', [
            'blog' => $results
        ]);
    }
    
    
    /**
     * Edit / update a blog post.
     * 
     * return @void
     */
    public function editAction()
    {
        $blog = new Blog();
        
        // Get the ID number
        $post_id = filter_var($this->route_params['id'], FILTER_SANITIZE_NUMBER_INT);
        
        // Read one post at ID
        $results = $blog->read($post_id);

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
     * Delete a blog post by ID.
     * 
     * return @void
     */
    public function removeAction() {
        $blog = new Blog();
        
        echo "here";
        
        // Get the ID number
        $post_id = filter_var($this->route_params['id'], FILTER_SANITIZE_NUMBER_INT);
        
        // Read one post at ID
        $results = $blog->delete($post_id);

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
    public function deleteAction()
    {   
        $blog = new Blog();
        
        // Get the ID number
        $post_id = filter_var($this->route_params['id'], FILTER_VALIDATE_INT);
        
        // Read one post at ID
        $results = $blog->read($post_id);

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
    public function newAction()
    {
        View::renderTemplate('Post/new.html');
    }
    
    
    /**
     * Create a new blog post entry in the DB.
     * 
     * return @void
     */
    public function createAction()
    {
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

    
    /**
     * Update the blog to the database
     *
     * @return void
     */
    public function updateAction()
    {   
        $blog = new Blog(filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING));

        if ($blog->update()) {
            Flash::addMessage('Post updated', Flash::SUCCESS);
            $this->redirect('/post/show/' . $blog->id);
        } else {
            Flash::addMessage('Could not update post with blank entries', Flash::WARNING);
            $this->redirect('/post/edit/' . $blog->id);
        }
    }
    
    
    /**
     * Index of the blog entries displayed
     *
     * @return void
     */
    public function indexAction()
    {
        $blog = new Blog();
       
        if (!$results = $blog->read()) {
            Flash::addMessage('No blog posts exist', Flash::INFO);
        }
        View::renderTemplate('Post/index.html', [
            'blog' => $results
        ]);
    }
    
// End of post class.
}
