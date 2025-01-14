<?php

namespace Tests\Feature\Http\Controllers\api;

use App\Models\About;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\api\AboutController
 */
final class AboutControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function show_behaves_as_expected(): void
    {
        $about = About::factory()->create();

        $response = $this->get(route('abouts.show', $about));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }
}
