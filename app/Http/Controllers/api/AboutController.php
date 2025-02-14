<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AboutStoreRequest;
use App\Http\Requests\AboutUpdateRequest;
use App\Http\Resources\api\AboutResource;
use App\Models\About;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function show()
    {
        $data = [
            'image' => 'https://cdn-icons-png.flaticon.com/512/25/25231.png',
            'title' => 'About Us',
            'icon' => 'https://cdn-icons-png.flaticon.com/512/25/25231.png',
            'description' => 'about',
            'contact' => [
                [
                    'name' => 'website',
                    'link' => 'www.almarsa-gourmet.com',
                    'icon' => 'https://cdn-icons-png.flaticon.com/512/25/25231.png'
                ],
            ],
            'social' => [
                [
                    'name' => 'facebook',
                    'link' => 'facebook.com',
                    'icon' => 'https://cdn-icons-png.flaticon.com/512/25/25231.png'
                ],
                [
                    'name' => 'twitter',
                    'link' => 'twitter.com',
                    'icon' => 'https://cdn-icons-png.flaticon.com/512/25/25231.png'
                ],
                [
                    'name' => 'instagram',
                    'link' => 'instagram.com',
                    'icon' => 'https://cdn-icons-png.flaticon.com/512/25/25231.png'
                ]
            ],
            'about_cart' => [
                [
                    'title' => 'Add products to the basket',
                    'description' => '',
                    'icon' => 'https://cdn-icons-png.flaticon.com/512/25/25231.png'
                ],
                [
                    'title' => 'Validate your order',
                    'description' => 'Choose between self-pickup or home delivery in Muscat and Sohar',
                    'icon' => 'https://cdn-icons-png.flaticon.com/512/25/25231.png'
                ],
                [
                    'title' => 'A confirmation message will be sent on the day of the delivery',
                    'description' => 'We will share the time for your delivery/pick-up',
                    'icon' => 'https://cdn-icons-png.flaticon.com/512/25/25231.png'
                ],
                [
                    'title' => 'We accept both, credit cards and cash upon delivery/pick up',
                    'description' => 'We deliver on  Sunday, Monday, Tuesday, Wednesday and Thursday from 2:00 pm to 7:00 pm.',
                    'icon' => 'https://cdn-icons-png.flaticon.com/512/25/25231.png'
                ]
            ],
            'title_text' => 'HOW DOES IT WORK?',
            'subtitle' => 'Simply follow 4 steps',
            'about_text' => 'Al Marsa Fisheries is processing and selling fresh and frozen seafood in Oman for the past 15 years. Based on this experience Al Marsa Foods was established 5 years ago to supply the local market with the best-imported food products. We supply all the hypermarket chains and all the five-star hotels with a lot of very special products and we are proud to be the only local company to do so. It became therefore obvious to share this "Savoir fair" with the broader range of customers and this is the aim of Al Marsa Gourmet: to bring to all direct access to products that can not be found anywhere else in Oman',
        ];

        return response()->json([
            'status' => true,
            'message' => 'About',
            'data' => $data
        ]);
    }
}
