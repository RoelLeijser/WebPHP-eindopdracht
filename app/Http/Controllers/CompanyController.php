<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Layout;
use App\Models\Component;
use Illuminate\Database\Eloquent\Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Rules\ComponentValidation;

class CompanyController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'max:255'],
        ]);

        $user_id = Auth::user()->id;

        $company = Company::create([
            'name' => $request->name,
            'user_id' => $user_id,
        ]);

        Layout::create([
            'first_component' => 'introduction',
            'second_component' => 'adverts',
            'third_component' => 'reviews',
            'company_id' => $company->id,
        ]);

        return redirect()->route('company.show', $user_id)->with('success', __('company.company_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $company = Company::where('user_id', $id)->first();
        if (is_null($company)) {
            return view('company.create');
        }

        // get all tokens from each user at the company
        $apiTokens = $company->user()->get()->map(function ($user) {
            return $user->tokens;
        })->flatten();

        return view('company.show')->with([
            'company' => $company,
            'apiTokens' => $apiTokens,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $company = Company::findOrFail($id);
        return view('company.edit')->with(compact('company'));
    }

    public function destroy($id): RedirectResponse
    {    
        try {
            $company = Company::findOrFail($id);
            $company->delete();
            return redirect()->route('account.index')->with('success', __('company.company_deleted'));

        } catch (ModelNotFoundException $e) {
            return redirect()->route('account.index')->with('error', __('company.company_not_found'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'name' => ['required', 'min:3', 'max:255', Rule::unique('companies')->ignore($id)],
            'logo' => ['image', 'mimes:jpeg,jpg', 'max:20000'],
            'slug' => ['max:55', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/i', Rule::unique('companies')->ignore($id)],
            'primary_color' => ['regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'secondary_color' => ['regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
        ]);

        try {
            $company = Company::findOrFail($id);
            $company->update([
                'slug' => $request->slug,
                'font_style' => $request->font,
                'name' => $request->name,
                'introduction_text' => $request->introduction,
                'primary_color' => $request->primary_color,
                'secondary_color' => $request->secondary_color,
            ]);

            if ($request->hasFile('logo')) {
                $company->update([
                    'logo' => $request->file('logo')->store('logos', 'public'),
                ]);
            }

            return redirect()->route('company.show', $company->user_id)->with('success', __('company.success_update'));
        } catch (Exception $e) {
            return redirect()->route('company.edit', $id)->with('error', __('company.fail_update'));
        }
    }

    public function showLandingPage($slug): View
    {
        $company = Company::where('slug', $slug)->with('layout')->first();

        if (is_null($company)) {
            abort(404);
        }

        return view('landingpage')->with(compact('company'));
    }

    public function editPageLayout($id): View
    {
        $components = Component::all()->pluck('name');
        $layout = Layout::where('company_id', $id)->first();
        return view('company.layout')->with(compact('layout', 'components'));
    }

    public function updatePageLayout(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'first' => [new ComponentValidation($request->all())],
            'second' => [new ComponentValidation($request->all())],
            'third' => [new ComponentValidation($request->all())],
        ]);

        try {
            $layout = Layout::findOrFail($id);
            $company = Company::where('id', $layout->company_id)->first();
            $layout->update([
                'first_component' => $request->first,
                'second_component' => $request->second,
                'third_component' => $request->third,
            ]);

            return redirect()->route('company.show', $company->user_id)->with('success', __('company.success_update'));
        } catch (Exception $e) {
            return redirect()->route('company.edit', $company->id)->with('error', __('company.fail_update'));
        }
    }

    public function createApiToken(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
        ]);

        $token = $request->user()->createToken($request->name)->plainTextToken;

        return redirect()->route('company.show', Auth::user()->id)->with(
            [
                'success' => __('company.api_token_created'),
                'token' => explode('|', $token)[1]
            ]
        );
    }

    public function deleteApiToken(int $id, Request $request)
    {
        $request->user()->tokens()->where('id', $id)->delete();

        return redirect()->route('company.show', Auth::user()->id)->with('success', __('company.api_token_deleted'));
    }
}
