<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('account.edit.title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if(session()->has('error'))
            <x-flash-message class="bg-red-100 dark:bg-red-100">{{ session('error') }}</x-flash-message>
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="py-4 px-3">
                        <h1><strong>{{ __('account.edit.name') }}</strong>{{ $account->name }}</h1>
                        <h1><strong>{{ __('account.edit.email') }}</strong>{{ $account->email }}</h1>
                    </div>
                   <div class="py-4 px-3">
                        <form method="post" action="{{route('account.update', $account->id)}}">
                            @csrf
                            @method('PUT')
                            <input name="name" hidden value="{{$account->name}}">
                            <input name="email" hidden value="{{$account->email}}">
                            <div class="py-1">
                                <label class="text-lg" for="role">{{ __('account.edit.role') }}</label>
                                <x-select name="role" class="block mt-1 rounded">
                                    @foreach($roles as $role)
                                        <x-option :value="$role" :selected="$account->roles->first()->name == $role">{{ucWords($role)}}</x-option>
                                    @endforeach
                                </x-select>
                                <x-input-error :messages="$errors->get('role')" class="mt-2" />
                            </div>
                            <div class="py-4">
                                <label class="text-lg" for="permissions">{{ __('account.edit.permission') }}</label>
                                <hr/>
                                    <div class="grid grid-cols-4">
                                        @foreach($permissions as $permission)
                                            <div class="py-1">
                                                <input type="checkbox" name="permissions[]" value="{{$permission}}" {{ $account->hasPermissionTo($permission) ? 'checked' : '' }}>
                                                <label>{{ucWords($permission)}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <x-input-error :messages="$errors->get('permissions')" class="mt-2" />
                                </select>
                            </div>
                            <div class="py-4">
                                <x-primary-button>{{ __('account.edit.button') }}</x-primary-button>
                            </div>
                        </form>
                   </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
