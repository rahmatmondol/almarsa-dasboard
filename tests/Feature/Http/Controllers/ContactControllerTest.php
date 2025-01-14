<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ContactController
 */
final class ContactControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $contacts = Contact::factory()->count(3)->create();

        $response = $this->get(route('contacts.index'));

        $response->assertOk();
        $response->assertViewIs('contact.index');
        $response->assertViewHas('contacts');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('contacts.create'));

        $response->assertOk();
        $response->assertViewIs('contact.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ContactController::class,
            'store',
            \App\Http\Requests\ContactStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $banner_background = $this->faker->word();
        $banner_title = $this->faker->word();
        $banner_image = $this->faker->word();
        $title = $this->faker->sentence(4);
        $content = $this->faker->paragraphs(3, true);
        $icons = $this->faker->;

        $response = $this->post(route('contacts.store'), [
            'banner_background' => $banner_background,
            'banner_title' => $banner_title,
            'banner_image' => $banner_image,
            'title' => $title,
            'content' => $content,
            'icons' => $icons,
        ]);

        $contacts = Contact::query()
            ->where('banner_background', $banner_background)
            ->where('banner_title', $banner_title)
            ->where('banner_image', $banner_image)
            ->where('title', $title)
            ->where('content', $content)
            ->where('icons', $icons)
            ->get();
        $this->assertCount(1, $contacts);
        $contact = $contacts->first();

        $response->assertRedirect(route('contacts.index'));
        $response->assertSessionHas('contact.id', $contact->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->get(route('contacts.show', $contact));

        $response->assertOk();
        $response->assertViewIs('contact.show');
        $response->assertViewHas('contact');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->get(route('contacts.edit', $contact));

        $response->assertOk();
        $response->assertViewIs('contact.edit');
        $response->assertViewHas('contact');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ContactController::class,
            'update',
            \App\Http\Requests\ContactUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $contact = Contact::factory()->create();
        $banner_background = $this->faker->word();
        $banner_title = $this->faker->word();
        $banner_image = $this->faker->word();
        $title = $this->faker->sentence(4);
        $content = $this->faker->paragraphs(3, true);
        $icons = $this->faker->;

        $response = $this->put(route('contacts.update', $contact), [
            'banner_background' => $banner_background,
            'banner_title' => $banner_title,
            'banner_image' => $banner_image,
            'title' => $title,
            'content' => $content,
            'icons' => $icons,
        ]);

        $contact->refresh();

        $response->assertRedirect(route('contacts.index'));
        $response->assertSessionHas('contact.id', $contact->id);

        $this->assertEquals($banner_background, $contact->banner_background);
        $this->assertEquals($banner_title, $contact->banner_title);
        $this->assertEquals($banner_image, $contact->banner_image);
        $this->assertEquals($title, $contact->title);
        $this->assertEquals($content, $contact->content);
        $this->assertEquals($icons, $contact->icons);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->delete(route('contacts.destroy', $contact));

        $response->assertRedirect(route('contacts.index'));

        $this->assertModelMissing($contact);
    }
}
