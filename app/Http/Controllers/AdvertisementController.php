<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\Permission\Traits\HasRoles;
use PhpOffice\PhpSpreadsheet\Reader\Csv;

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
            ->allowedIncludes(['seller', 'renter'])
            ->defaultSort('-created_at')
            ->allowedSorts(['price', 'created_at'])
            ->where([
                ['end_date', '>', now()],
            ])
            ->whereDoesntHave('renter', function ($query) {
                $query->where('end_date', '>', now());
            })
            ->paginate(10)
            ->appends(request()->query());

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
        return view(
            'advertisements.create',
            ['allAdvertisements' => Advertisement::where('seller_id', auth()->id())->get()]
        );
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
            'linkedAdvertisements' => 'array|max:3',
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

        $advertisement->linkedAdvertisements()->attach($request->linkedAdvertisements);

        return redirect()->route('advertisements.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $advertisement = Advertisement::with(['bids' => function ($query) {
            $query->orderBy('amount', 'asc'); // Orders bids by highest bid amount
        }, 'seller', 'linkedAdvertisements'])->findOrFail($id);

        $reviews = $advertisement->reviews()->with('user')->orderByDesc('published_at')->paginate(3);

        return view('advertisements.show', [
            'advertisement' => $advertisement,
            'isFavorite' => Auth::user() && Auth::user()->favorites->contains('advertisement_id', $id),
            'reviews' => $reviews,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('advertisements.edit', [
            'advertisement' => Advertisement::findOrFail($id),
            'allAdvertisements' => Advertisement::where('seller_id', auth()->id())
                ->where('id', '!=', $id)
                ->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $advertisement = Advertisement::findOrFail($id);
        $user = Auth::user();

        if (($advertisement->seller_id !== auth()->id()) || $user->hasRole('admin')) {
            return redirect()->route('advertisements.index')
                ->with('error', 'You can only edit your own advertisements.');
        }

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
        $advertisement->linkedAdvertisements()->sync($request->linkedAdvertisements);

        return redirect()->route('advertisements.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if ((Advertisement::findOrFail($id)->seller_id !== auth()->id()) || Auth::user()->hasRole('admin')) {
            return redirect()->route('advertisements.index')
                ->with('error', 'You can only delete your own advertisements.');
        }

        $image = Advertisement::findOrFail($id)->image;
        if (file_exists(public_path($image))) {
            unlink(public_path($image));
        }

        Advertisement::findOrFail($id)->delete();

        return redirect()->route('advertisements.index');
    }

    public function advertisementsByUser($id)
    {
        $advertisements = Advertisement::where('seller_id', $id)->orderBy('created_at', 'desc')->with('seller')->paginate(5);
        $user = User::findOrFail($id);

        $reviews = $user->reviews()->with('user')->orderByDesc('published_at')->paginate(3);

        return view('advertisements.user', compact('advertisements', 'reviews'));
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

    public function createCSV()
    {
        return view('advertisements.createcsv');
    }

    public function storeCSV(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        $reader = new Csv();
        $reader->setDelimiter(';');
        $reader->setEnclosure('"');
        $reader->setSheetIndex(0);
        $spreadsheet = $reader->load($request->file('file')->getPathname());
        $rows = $spreadsheet->getActiveSheet()->toArray();



        foreach ($rows as $row) {
            if (count($row) !== 6) {
                return redirect()->route('advertisements.createcsv')
                    ->withErrors("The CSV file doesn't have the correct amount of columns.");
            }

            if (in_array("", $row)) {
                return redirect()->route('advertisements.createcsv')
                    ->withErrors('The CSV file must not have empty columns.');
            }

            $advertisementCount = Advertisement::where('seller_id', auth()->id())
                ->where('type', $row[4])
                ->count();

            if ($advertisementCount >= 4) {
                return redirect()->route('advertisements.createcsv')
                    ->withErrors('You can only have four advertisements of each type.');
            }

            if (!in_array($row[4], ['auction', 'sell', 'rental'])) {
                return redirect()->route('advertisements.createcsv')
                    ->withErrors('Type must be auction, sell or rental.');
            }

            if (!in_array($row[5], ['pickup', 'shipping', 'pickup_shipping'])) {
                return redirect()->route('advertisements.createcsv')
                    ->withErrors('Delivery must be pickup, shipping or pickup_shipping.');
            }
        }

        foreach ($rows as $row) {
            Advertisement::create([
                'title' => $row[0],
                'description' => $row[1],
                'seller_id' => auth()->id(),
                'price' => $row[2],
                'image' => $row[3],
                'type' => $row[4],
                'delivery' => $row[5],
            ]);
        }

        return redirect()->route('advertisements.index');
    }

    public function rent(Request $request, string $id)
    {
        $advertisement = Advertisement::findOrFail($id);

        if ($advertisement->seller_id === auth()->id()) {
            return redirect()->route('advertisements.show', $id)
                ->withErrors('You can not rent your own advertisement.');
        }

        if ($advertisement->renter()->where([
            ['user_id', auth()->id()],
            ['end_date', '>', now()],
        ])->exists()) {
            return redirect()->route('advertisements.show', $id)
                ->withErrors('You have already rented this advertisement.');
        }
        if ($advertisement->renter()->where('end_date', '>', now())->exists()) {
            return redirect()->route('advertisements.show', $id)
                ->withErrors('This advertisement is already rented.');
        }

        $advertisement->renter()->attach(auth()->id(), [
            'start_date' => now(),
            'end_date' => now()->addDays(7),
        ]);

        return redirect()->route('advertisements.show', $id);
    }
}
