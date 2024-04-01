<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use App\Models\Advertisement;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ReviewController extends Controller
{
    public function storeForAdvertisements(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'review' => ['required', 'max:1000'],
        ]);

        try {
            $author = Auth::user();
            $advertisement = Advertisement::findOrFail($id);
            if(!is_null($advertisement)) 
            {
                $review = Review::create([
                    'review' => $request->review,
                    'published_at' => now(),
                    'user_id' => $author->id,
                ]);

                $advertisement->reviews()->attach($review->id);
            }

            return redirect()->route('advertisements.show', $advertisement->id)->with('success', __('review.comitted'));

        } catch (Exception $e) {
            return redirect()->route('advertisements.index')->with('error', __('review.failed_create'));
        }

    }

    public function storeForUser(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'review' => ['required', 'max:1000'],
        ]);

        try {
            $author = Auth::user();
            $user = User::findOrFail($id);
            if(!is_null($user)) 
            {
                $review = Review::create([
                    'review' => $request->review,
                    'published_at' => Carbon::now(),
                    'user_id' => $author->id,
                ]);

                $user->reviews()->attach($review->id);
            }

            return redirect()->route('advertisements.user', $id)->with('success', __('review.comitted'));

        } catch (Exception $e) {
            return redirect()->route('advertisements.user', $id)->with('error', __('review.failed_create')); 
        }
    }

    public function destroy($id): RedirectResponse
    {
        try {
            $review = Review::findOrFail($id);
            $review->delete();

            return redirect()->back()->with('success', __('review.success_destroy'));
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', __('review.failed_destroy'));
        }
    }

    public function edit($id): View
    {
        $review = Review::findOrFail($id);
        return view('review.edit')->with(compact('review'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {

        $request->validate([
            'review' => ['required', 'max:1000'],
        ]);

        try {
            $review = Review::findOrFail($id);
            $review->update([
                'review' => $request->review,
            ]);

            return redirect()->back()->with('success', __('review.success_update'));

        } catch (Exception $e) {
            return redirect()->back()->with('error', __('review.failed_update'));
        }
    }
}
