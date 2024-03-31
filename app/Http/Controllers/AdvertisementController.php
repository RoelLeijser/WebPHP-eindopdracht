<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advertisement;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $advertisements = QueryBuilder::for(Advertisement::class)
            ->allowedFilters([
                'title',
                'type',
                'delivery',
                AllowedFilter::exact('seller_id'),
                AllowedFilter::scope('price')
            ])
            ->allowedIncludes(['seller'])
            ->defaultSort('-created_at')
            ->allowedSorts(['price', 'created_at'])
            ->paginate(10);

        return view('advertisements.index', [
            'advertisements' => $advertisements,
            'price' => [
                Advertisement::min('price'), Advertisement::max('price')
            ]
        ]);
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
        $advertisement = Advertisement::with(['bids' => function ($query) {
            $query->orderBy('amount', 'asc'); // Orders bids by highest bid amount
        }, 'seller'])->findOrFail($id);

        return view('advertisements.show', [
            'advertisement' => $advertisement,
            'isFavorite' =>  Auth::user() && Auth::user()->favorites->contains('advertisement_id', $id)
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
        //delete image
        $image = Advertisement::findOrFail($id)->image;
        if (file_exists(public_path($image))) {
            unlink(public_path($image));
        }

        Advertisement::findOrFail($id)->delete();

        return redirect()->route('advertisements.index');
    }

    /**
     * Add a bid to the advertisement.
     */
    public function bid(Request $request, string $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        if (Advertisement::findOrFail($id)->seller_id === auth()->id()) {
            return redirect()->route('advertisements.show', $id)
                ->withErrors('You can not bid on your own advertisement.');
        }

        $highestBid = Advertisement::findOrFail($id)->bids()->max('amount')
            ?? Advertisement::findOrFail($id)->price;

        if ($request->amount <= $highestBid) {
            return redirect()->route('advertisements.show', $id)
                ->withErrors('Your bid must be higher than the current highest bid.');
        }

        $existingBid = Advertisement::findOrFail($id)->bids()->where('user_id', auth()->id())->first();
        if ($existingBid) {
            $existingBid->delete();
        }

        Advertisement::findOrFail($id)->bids()->create([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
        ]);

        return redirect()->route('advertisements.show', $id);
    }

    /**
     * Favorite the advertisement.
     */
    public function favorite(string $id)
    {

        $existingFavorite = Favorite::where('user_id', auth()->id())
            ->where('advertisement_id', $id)
            ->first();

        if ($existingFavorite) {
            $existingFavorite->delete();
        } else {
            Favorite::create([
                'user_id' => auth()->id(),
                'advertisement_id' => $id,
            ]);
        }

        return redirect()->route('advertisements.show', $id);
    }
}
