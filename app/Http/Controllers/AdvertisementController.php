<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advertisement;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $advertisements = Advertisement::with('seller')->get();
        return view('advertisements.index', compact('advertisements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('advertisements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'required',
            'delivery' => 'required',
        ]);

        //more more than four with each type per person
        $advertisementCount = Advertisement::where('seller_id', auth()->id())
            ->where('type', $request->type)
            ->count();

        if ($advertisementCount >= 4) {
            return redirect()->route('advertisements.create')
                ->with('error', 'You can only have four advertisements of each type.');
        }

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        Advertisement::create([
            'title' => $request->title,
            'description' => $request->description,
            'seller_id' => auth()->id(),
            'price' => $request->price,
            'image' => '/images/' . $imageName,
            'type' => $request->type,
            'delivery' => $request->delivery,
        ]);

        return redirect()->route('advertisements.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Advertisement::findOrFail($id);

        return view('advertisements.show', [
            'advertisement' => Advertisement::with('seller')->findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('advertisements.edit', [
            'advertisement' => Advertisement::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $advertisement = Advertisement::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'required',
            'delivery' => 'required',
        ]);
        $advertisementCount = Advertisement::where('seller_id', auth()->id())
            ->where('type', $request->type)
            ->count();

        if ($advertisementCount >= 4) {
            return redirect()->route('advertisements.edit', $advertisement->id)
                ->with('error', 'You can only have four advertisements of each type.');
        }

        if ($request->hasFile('image')) {
            $imageName = "/images/" . time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        } else {
            $imageName = $advertisement->image;
        }

        $advertisement->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imageName,
            'type' => $request->type,
            'delivery' => $request->delivery,
        ]);

        return redirect()->route('advertisements.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Advertisement::findOrFail($id)->delete();

        return redirect()->route('advertisements.index');
    }
}
