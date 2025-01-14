<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\About;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AboutController
 */
final class AboutControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $abouts = About::factory()->count(3)->create();

        $response = $this->get(route('abouts.index'));

        $response->assertOk();
        $response->assertViewIs('about.index');
        $response->assertViewHas('abouts');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('abouts.create'));

        $response->assertOk();
        $response->assertViewIs('about.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AboutController::class,
            'store',
            \App\Http\Requests\AboutStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $about = $this->faker->text();

        $response = $this->post(route('abouts.store'), [
            'about' => $about,
        ]);

        $abouts = About::query()
            ->where('about', $about)
            ->get();
        $this->assertCount(1, $abouts);
        $about = $abouts->first();

        $response->assertRedirect(route('abouts.index'));
        $response->assertSessionHas('about.id', $about->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $about = About::factory()->create();

        $response = $this->get(route('abouts.show', $about));

        $response->assertOk();
        $response->assertViewIs('about.show');
        $response->assertViewHas('about');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $about = About::factory()->create();

        $response = $this->get(route('abouts.edit', $about));

        $response->assertOk();
        $response->assertViewIs('about.edit');
        $response->assertViewHas('about');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AboutController::class,
            'update',
            \App\Http\Requests\AboutUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $about = About::factory()->create();
        $about = $this->faker->text();

        $response = $this->put(route('abouts.update', $about), [
            'about' => $about,
        ]);

        $about->refresh();

        $response->assertRedirect(route('abouts.index'));
        $response->assertSessionHas('about.id', $about->id);

        $this->assertEquals($about, $about->about);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $about = About::factory()->create();

        $response = $this->delete(route('abouts.destroy', $about));

        $response->assertRedirect(route('abouts.index'));

        $this->assertModelMissing($about);
    }
}
