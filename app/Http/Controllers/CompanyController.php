<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Database\Eloquent\Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

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
        if(!$company->exists()) {
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
            'name' => ['required', 'min:3', 'max:255'],
            'slug' => ['max:55', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/i'],
            'color' => ['regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'introduction' => ['max:255'],
        ]);

        try {
            $company = Company::findOrFail($id);
            $company->update([
                'custom_url' => $request->slug,
                'font_style' => $request->font,
                'name' => $request->name,
                'introduction_text' => $request->introduction,
                'color_modification' => $request->color,
            ]);

            return redirect()->route('company.show', $company->user_id)->with('success', __('company.success_update'));
        }
        catch(Exception $e) {
           return redirect()->route('company.edit', $id)->with('error', __('company.fail_update'));
        }
    }
}
