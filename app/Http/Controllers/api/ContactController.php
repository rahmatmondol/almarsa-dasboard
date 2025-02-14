<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactStoreRequest;
use App\Http\Requests\ContactUpdateRequest;
use App\Http\Resources\api\ContactResource;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show()
    {
        $data = [
            'title' => 'Contact',
            'subtitle' => 'Contact',
            'contact' => 'Please do not hesitate to get in touch with any questions or feedback. TAP ICONS BELOW TO CALL OR EMAIL',
            'contact_list' => [
                [
                    'title' => 'Email',
                    'link' => 'mailto:qI8mD@example.com',
                    'icon' => 'https://cdn-icons-png.flaticon.com/512/25/25231.png'
                ],
                [
                    'title' => 'Phone',
                    'link' => 'tel:0123456789',
                    'icon' => 'https://cdn-icons-png.flaticon.com/512/25/25231.png'
                ]
            ]
        ];

        return response()->json([
            'success' => true,
            'message' => 'Contact retrieved successfully',
            'data' => $data
        ]);
    }
}
