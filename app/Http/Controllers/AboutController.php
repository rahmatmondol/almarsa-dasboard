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
    public function index(Request $request): Response
    {
        $abouts = About::all();

        return view('about.index', compact('abouts'));
    }

    public function create(Request $request): Response
    {
        return view('about.create');
    }

    public function store(AboutStoreRequest $request): Response
    {
        $about = About::create($request->validated());

        $request->session()->flash('about.id', $about->id);

        return redirect()->route('abouts.index');
    }

    public function show(Request $request, About $about): Response
    {
        return view('about.show', compact('about'));
    }

    public function edit(Request $request, About $about): Response
    {
        return view('about.edit', compact('about'));
    }

    public function update(AboutUpdateRequest $request, About $about): Response
    {
        $about->update($request->validated());

        $request->session()->flash('about.id', $about->id);

        return redirect()->route('abouts.index');
    }

    public function destroy(Request $request, About $about): Response
    {
        $about->delete();

        return redirect()->route('abouts.index');
    }
}
