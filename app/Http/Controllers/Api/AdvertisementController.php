<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //optional parameter to paginate the results
    public function index()
    {
        return Response()->json(Advertisement::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
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

            $advertisement = Advertisement::create([
                'title' => $request->title,
                'description' => $request->description,
                'seller_id' => auth()->id(),
                'price' => $request->price,
                'image' => '/images/' . $imageName,
                'type' => $request->type,
                'delivery' => $request->delivery,
            ]);

            return Response()->json($advertisement, 201);
        } catch (\Exception $e) {
            return Response()->json($e->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Advertisement $advertisement)
    {
        return Response()->json($advertisement);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Advertisement $advertisement)
    {
        $advertisement->update($request->only(['title', 'description', 'price', 'type', 'delivery']));

        return Response()->json($advertisement);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advertisement $advertisement)
    {
        $advertisement->delete();
        return Response()->json(null, 204);
    }
}
