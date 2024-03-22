<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('account.edit.title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div>
                        <h1><strong>Naam: </strong>{{ $account->name }}</h1>
                        <h1><strong>Email: </strong>{{ $account->email }}</h1>
                    </div>
                   <div>
                        <form method="post" action="#">
                            <div>
                                <label for="role">Wijzig rol</label>
                                <select dusk="role" name="role" class="block mt-1 w-full rounded">
                                    @foreach($roles as $role)
                                        <option value="{{$role}}" {{ $account->roles->first()->name == $role ? 'selected' : '' }}>{{ucWords($role)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label>Wijzig permissies</label>
                                    @foreach($roles as $role) <!-- TODO: change to all permission -->
                                        <div>
                                            <input type="checkbox" name="permissions">
                                            <label for="">Permission</label>
                                        </div>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <button type="submit">Wijzig account</button>
                            </div>
                        </form>
                   </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
