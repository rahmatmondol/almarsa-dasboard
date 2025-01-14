<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CartController
 */
final class CartControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $carts = Cart::factory()->count(3)->create();

        $response = $this->get(route('carts.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CartController::class,
            'store',
            \App\Http\Requests\CartStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $sub_total = $this->faker->randomFloat(/** decimal_attributes **/);
        $total = $this->faker->randomFloat(/** decimal_attributes **/);
        $user = User::factory()->create();

        $response = $this->post(route('carts.store'), [
            'sub_total' => $sub_total,
            'total' => $total,
            'user_id' => $user->id,
        ]);

        $carts = Cart::query()
            ->where('sub_total', $sub_total)
            ->where('total', $total)
            ->where('user_id', $user->id)
            ->get();
        $this->assertCount(1, $carts);
        $cart = $carts->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $cart = Cart::factory()->create();

        $response = $this->get(route('carts.show', $cart));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CartController::class,
            'update',
            \App\Http\Requests\CartUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $cart = Cart::factory()->create();
        $sub_total = $this->faker->randomFloat(/** decimal_attributes **/);
        $total = $this->faker->randomFloat(/** decimal_attributes **/);
        $user = User::factory()->create();

        $response = $this->put(route('carts.update', $cart), [
            'sub_total' => $sub_total,
            'total' => $total,
            'user_id' => $user->id,
        ]);

        $cart->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($sub_total, $cart->sub_total);
        $this->assertEquals($total, $cart->total);
        $this->assertEquals($user->id, $cart->user_id);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $cart = Cart::factory()->create();

        $response = $this->delete(route('carts.destroy', $cart));

        $response->assertNoContent();

        $this->assertModelMissing($cart);
    }
}
