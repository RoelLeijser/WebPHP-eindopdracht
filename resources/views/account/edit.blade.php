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
                <div class="dark:text-gray-100 p-6 text-gray-900">
                    <div class="py-4 px-3 grid grid-cols-2">
                        <div>
                            <h1><strong>{{ __('account.edit.name') }}</strong>{{ $account->name }}</h1>
                            <h1><strong>{{ __('account.edit.email') }}</strong>{{ $account->email }}</h1>
                            @if(!is_null($account->company))
                                <h1><strong>{{ __('company.name') }} </strong>{{ $account->company->name }}</h1>
                            @endif
                        </div>
                            @if($account->roles->first()->name == 'zakelijke adverteerder')
                                <div class="flex justify-end px-3 py-4">
                                    <div class="py-2 px-2">
                                        <a href="{{ route('contract.export', $account->id)}}"><x-secondary-button>{{__('contract.export')}}</x-secondary-button></a>
                                    </div>
                                    <div class="py-2 px-2">
                                        <form method="post" action="{{route('contract.verify', $account->id)}}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="pb-3">
                                                <input type="file" name="contract">
                                                <x-input-error :messages="$errors->get('contract')" class="mt-2" />
                                            </div>
                                           <div>
                                                <x-primary-button dusk="upload"> {{__('contract.upload')}}</x-primary-button>
                                           </div>
                                        </form>
                                    </div>
                                </div>
                            @endif
                    </div>
                   <div class="py-4 px-3">
                        <form method="post" action="{{route('account.update', $account->id)}}">
                            @csrf
                            @method('PUT')
                            <input name="name" hidden value="{{$account->name}}">
                            <input name="email" hidden value="{{$account->email}}">
                            <div class="py-1">
                                <label class="text-lg" for="role">{{ __('account.edit.role') }}</label>
                                <x-select dusk="select" name="role" class="block mt-1 rounded">
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
                            <div class="py-4 flex flex-end">
                                <x-primary-button dusk="update">{{ __('account.edit.button') }}</x-primary-button>
                            </div>
                        </form>
                        <div class="py-2 flex justify-between">
                            @if(!is_null($account->company))
                                <form method="post" action="{{ route('company.destroy', $account->company->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button dusk="delete"> {{__('company.delete_button')}}</x-danger-button>
                                    </form>
                            @endif
                        </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
