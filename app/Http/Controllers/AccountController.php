<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Rules\RoleExist;
use App\Rules\PermissionExist;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index(): View
    {
        $sort = request('sort', 'asc');

        $roles = Role::all()->pluck('name');
        $accounts = User::filter(request(['search', 'role']))->orderBy('name', $sort)->with('roles')->paginate(5);

        $nextSort = $sort === 'asc' ? 'desc' : 'asc';
        return view('account.index')->with(compact('accounts', 'nextSort', 'roles'));
    }

    public function edit($id): View
    {
        $account = User::findOrFail($id);
        $roles = Role::all()->pluck('name');
        $permissions = Permission::all()->pluck('name');

        return view('account.edit')->with(compact('account', 'roles', 'permissions'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'permissions' => [new PermissionExist],
            'role' => ['required', new RoleExist],
        ]);

        try {
            $account = User::findOrFail($id);
            $account->syncRoles($request->role);
            $account->syncPermissions($request->permissions);

            return redirect()->route('account.index')->with('success', __('account.edit.success'));
        } catch (Exception $e) {
            return redirect()->route('account.edit', $id)->with('error', __('account.edit.fail'));
        }
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

    // favorites
    public function favorites(): View
    {
        $account = Auth::user();
        $advertisements = Advertisement::whereIn('id', $account->favorites->pluck('advertisement_id'))->paginate(5);
        return view('account.favorites')->with(compact('advertisements'));
    }
}
