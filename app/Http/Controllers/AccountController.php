<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use App\Models\User;

class AccountController extends Controller
{
    public function index() : View
    {
        $sort = request('sort','asc');

        $roles = Role::all()->pluck('name');
        $accounts = User::filter(request(['search', 'role']))->orderBy('name', $sort)->with('roles')->paginate(5);

        $nextSort = $sort === 'asc' ? 'desc' : 'asc';
        return view('account.index')->with(compact('accounts', 'nextSort', 'roles'));
    }

    public function show() : View
    {
        return view('show');
    }

    public function edit() : View
    {
        return view('show');
    }

    public function update(): RedirectResponse
    {
        return Redirect::to('/');
    }

    public function destroy($id): RedirectResponse
    {    
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->route('account.index')->with('success', __('account.user_deleted'));

        } catch (ModelNotFoundException $e) {
            return redirect()->route('account.index')->with('error', __('account.user_not_found'));
        }
    }
}
