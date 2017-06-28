<?php

namespace App\Models;

include_once '../App/Models/Blog.php';

/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-06-26 at 17:43:49.
 */
class BlogTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Blog
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Blog;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    /**
     * @covers App\Models\Blog::read
     * 
     * Test a read for an entry that does not exist.
     */
    public function testRead() {
        $arr = $this->object->read(-1);
        $this->assertTrue($arr == false);
    }

    /**
     * @covers App\Models\Blog::save
     * @todo   Implement testSave().
     */
    public function testSave() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers App\Models\Blog::update
     * @todo   Implement testUpdate().
     */
    public function testUpdate() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers App\Models\Blog::delete
     * @todo   Implement testDelete().
     */
    public function testDelete() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers App\Models\Blog::validate
     * @todo   Implement testValidate().
     */
    public function testValidate() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

}
