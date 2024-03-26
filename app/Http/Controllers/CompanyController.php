<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Database\Eloquent\Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'max:255'],
        ]);

        $user_id = Auth::user()->id;

        Company::create([
            'name' => $request->name,
            'user_id' => $user_id,
        ]);

        return redirect()->route('company.show', $user_id)->with('success', __('company.company_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id) : View
    {
        $company = Company::where('user_id', $id)->first();
        if(is_null($company)) {
            return view('company.create');
        }
       
        return view('company.show')->with(compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $company = Company::findOrFail($id);
        return view('company.edit')->with(compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'name' => ['required', 'min:3', 'max:255', Rule::unique('companies')->ignore($id)],
            'logo' => ['image', 'mimes:jpeg,jpg'],
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
        }
        catch(Exception $e) {
           return redirect()->route('company.edit', $id)->with('error', __('company.fail_update'));
        }
    }

    public function showLandingPage($slug): View
    {
        $company = Company::where('slug', $slug)->first();
        if(is_null($company)) {
            abort(404);
        }

        return view('landingpage')->with(compact('company'));
    }
}
