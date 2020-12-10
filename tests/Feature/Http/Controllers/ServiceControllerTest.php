<?php

namespace Tests\Feature\Http\Controllers;

use App\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ServiceController
 */
class ServiceControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $services = Service::factory()->count(3)->create();

        $response = $this->get(route('service.index'));

        $response->assertOk();
        $response->assertViewIs('service.index');
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $service = Service::factory()->create();

        $response = $this->get(route('service.show', $service));

        $response->assertOk();
        $response->assertViewIs('service.show');
        $response->assertViewHas('service');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $service = Service::factory()->create();

        $response = $this->get(route('service.edit', $service));

        $response->assertOk();
        $response->assertViewIs('service.edit');
        $response->assertViewHas('service');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('service.create'));

        $response->assertOk();
        $response->assertViewIs('service.create');
    }


    /**
     * @test
     */
    public function update_saves_and_redirects()
    {
        $service = Service::factory()->create();

        $response = $this->put(route('service.update', $service));

        $response->assertRedirect(route('service.index'));

        $this->assertDatabaseHas(services, [ /* ... */ ]);
    }


    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $response = $this->post(route('service.store'));

        $response->assertRedirect(route('service.index'));
        $response->assertSessionHas('service.id', $service->id);

        $this->assertDatabaseHas(services, [ /* ... */ ]);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $service = Service::factory()->create();

        $response = $this->delete(route('service.destroy', $service));

        $response->assertRedirect(route('service.index'));

        $this->assertDeleted($service);
    }
}
