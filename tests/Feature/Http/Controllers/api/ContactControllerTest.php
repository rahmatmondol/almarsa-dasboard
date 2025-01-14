<?php

namespace Tests\Feature\Http\Controllers\api;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\api\ContactController
 */
final class ContactControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function show_behaves_as_expected(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->get(route('contacts.show', $contact));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }
}
