<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\DatabaseSeeder;
use App\Models\User;
use App\Models\Project;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_homepage_renders_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Designed for Living.');
        $response->assertSee('Built for Life.');
        $response->assertSee('ARKLE HOMES');
    }

    public function test_projects_page_renders_and_has_categories(): void
    {
        $response = $this->get('/projects');
        $response->assertStatus(200);
        $response->assertSee('Projects');
        $response->assertSee('Modern Family Home');
    }

    public function test_external_project_redirect_support(): void
    {
        $project = Project::where('slug', 'sunbury-haven')->first();
        $this->assertNotNull($project);
        $this->assertEquals('external', $project->link_type);
        $this->assertTrue($project->is_external);
        $this->assertEquals('https://www.realestate.com.au/sold/property-house-vic-sunbury-142916044', $project->destination_url);
        $this->assertEquals('_blank', $project->link_target);
        $this->assertEquals('noopener noreferrer', $project->link_rel);
    }

    public function test_contact_form_submission(): void
    {
        $response = $this->post('/contact', [
            'name' => 'John Test',
            'email' => 'john.test@example.com',
            'phone' => '0400123456',
            'project_type' => 'Custom Home',
            'message' => 'We are planning to build a custom home in Geelong.',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('contact_enquiries', [
            'email' => 'john.test@example.com',
        ]);
    }

    public function test_admin_login_and_dashboard_access(): void
    {
        $loginResponse = $this->get('/admin/login');
        $loginResponse->assertStatus(200);
        $loginResponse->assertSee('Control Panel Sign In');

        $admin = User::where('email', 'admin@arklehomes.com.au')->first();
        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Overview');
        $response->assertSee('Total Projects');
    }
}
