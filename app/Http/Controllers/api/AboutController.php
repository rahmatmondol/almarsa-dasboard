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
    public function show(Request $request, About $about): Response
    {
        return new AboutResource($about);
    }
}
