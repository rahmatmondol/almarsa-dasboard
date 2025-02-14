<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboutStoreRequest;
use App\Http\Requests\AboutUpdateRequest;
use App\Models\About;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(Request $request)
    {
        $about = About::all();

        return view('about.index', compact('about'));
    }

    public function store(AboutStoreRequest $request)
    {
        $about = About::create($request->validated());

        $request->session()->flash('about.id', $about->id);

        return redirect()->route('abouts.index');
    }

    public function update(AboutUpdateRequest $request, About $about)
    {
        $about->update($request->validated());

        $request->session()->flash('about.id', $about->id);

        return redirect()->route('abouts.index');
    }
}
