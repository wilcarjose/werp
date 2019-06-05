<?php

namespace Tests\Feature;

use Tests\TestCase;
use Werp\User;
use Werp\Modules\Core\Products\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ExampleTest extends TestCase
{
    use WithoutMiddleware;
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        shell_exec('php artisan migrate:fresh --seed --database=mysql_tests');
        $this->user = factory(User::class)->create();
        $this->actingAs($this->user);
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAdminPage()
    {   
        $response = $this->get('/admin/home');

        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCategoriesListPage()
    {        
        $response = $this->get('/admin/products/categories');

        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCategoriesNewPage()
    {        
        $response = $this->get('/admin/products/categories/create');

        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCategoriesEditPage()
    {   
        $category = factory(Category::class)->create();

        $response = $this->get('/admin/products/categories/'.$category->id.'/edit');

        $response->assertStatus(200);
    }
}
