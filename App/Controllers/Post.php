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
     * Show a single blog entry
     *
     * @return void
     */
    public function showAction()
    {   
        $blog = new Blog();
        
        // Get the ID number
        $post_id = $this->route_params['id'];
        
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
     * 
     */
    public function editAction()
    {
        echo "in editAction";
        
        $blog = new Blog();
        
        View::renderTemplate('Post/edit.html', [
            'blog' => $blog
        ]);
    }
    
    
    /**
     * New blog post entry, render the form teplate.
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
        $blog = new Blog($_POST);

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
        echo "in updateAction";
        
        $blog = new Blog();

        if ($blog->update()) {
            View::renderTemplate('Post/show.html', [
                'blog' => $blog
            ]);
        } else {
            $this->redirect('/post/index');
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
    
}
