<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
