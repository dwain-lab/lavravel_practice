<?php

namespace Tests\Feature\Http\Controllers;

use App\Phone;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PhoneController
 */
class PhoneControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $phones = Phone::factory()->count(3)->create();

        $response = $this->get(route('phone.index'));

        $response->assertOk();
        $response->assertViewIs('phone.index');
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $phone = Phone::factory()->create();

        $response = $this->get(route('phone.show', $phone));

        $response->assertOk();
        $response->assertViewIs('phone.show');
        $response->assertViewHas('phone');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $phone = Phone::factory()->create();

        $response = $this->get(route('phone.edit', $phone));

        $response->assertOk();
        $response->assertViewIs('phone.edit');
        $response->assertViewHas('phone');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('phone.create'));

        $response->assertOk();
        $response->assertViewIs('phone.create');
    }


    /**
     * @test
     */
    public function update_saves_and_redirects()
    {
        $phone = Phone::factory()->create();

        $response = $this->put(route('phone.update', $phone));

        $response->assertRedirect(route('phone.index'));

        $this->assertDatabaseHas(phones, [ /* ... */ ]);
    }


    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $response = $this->post(route('phone.store'));

        $response->assertRedirect(route('phone.index'));
        $response->assertSessionHas('phone.id', $phone->id);

        $this->assertDatabaseHas(phones, [ /* ... */ ]);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $phone = Phone::factory()->create();

        $response = $this->delete(route('phone.destroy', $phone));

        $response->assertRedirect(route('phone.index'));

        $this->assertDeleted($phone);
    }
}
