<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function show($id): View
    {
        return view(company.show);
    }
}
