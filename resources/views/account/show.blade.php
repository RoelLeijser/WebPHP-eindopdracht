<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('account.show.title') }}
        </h2>
    </x-slot>

    
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="px-3 py-2 flex">
                        <h1 class="text-xl">{{$account->name}}</h1>
                    </div>
                    <div class="px-3 py-2 grid grid-cols-2">
                        <h1><strong>{{ __('account.edit.email') }}</strong>{{ $account->email }}</h1>
                        <h1><strong>{{ __('account.show.role') }}</strong>{{ ucWords($account->roles->first()->name) }}</h1>
                        @if(!is_null($account->company))
                            <h1><strong>{{ __('account.show.company') }}</strong>{{ $account->company->name }}</h1>
                            <h1><strong>{{ __('account.show.slug') }}</strong><a class="font-medium text-blue-600 dark:text-blue-500 hover:underline" href="{{route('landingpage', $account->company->slug)}}">{{ $account->company->slug }}</a></h1>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
