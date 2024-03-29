<x-app-layout>
   <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('account.title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if(session()->has('success'))
            <x-flash-message class="bg-green-400 dark:bg-green-800">{{ session('success') }}</x-flash-message>
        @elseif(session()->has('error'))
            <x-flash-message class="bg-red-100 dark:bg-red-100">{{ session('error') }}</x-flash-message>
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900 dark:text-gray-100">
                    <div class="py-3">
                        <form id="filter-form" method="GET" class="flex flex-row justify-between" action="">
                            <div class="flex w-80">
                                <x-search></x-search>
                            </div>
                            <div class="flex">
                                <x-select dusk="select" name="role" form="filter-form" class="form-select w-full" onchange="this.form.submit()">
                                    <x-option>{{ __('account.role_filter') }}</x-option>
                                    @foreach($roles as $role)
                                            <x-option :value="$role" :selected="request('role') == $role">{{ucWords($role)}}</x-option>
                                    @endforeach
                                </x-select>
                            </div>
                        </form>
                        </div>
                    </div>

                    <div class=" px-3 relative overflow-x-auto shadow-md sm:rounded-lg">
                    @if($accounts->count() > 0)
                        <x-table>
                            <x-thead>
                                <x-table-col-name>{{ __('account.email') }}</x-table-col-name>
                                <x-table-col-name class="flex justify-center flex-row">
                                        <p>{{ __('account.name') }}</p>
                                        <a href="{{ route('account.index', ['sort' => $nextSort, 'search' => request('search'), 'role' => request('role')]) }}">
                                            <x-sort-image/>
                                        </a>
                                </x-table-col-name>
                                <x-table-col-name> {{ __('account.role') }} </x-table-col-name>
                                <x-table-col-name> {{ __('account.actions') }}</x-table-col-name>
                                <x-table-col-name></x-table-col-name>
                            </x-thead>
                            <tbody>
                                @foreach($accounts as $account)
                                    <x-table-row>
                                        <x-table-cell class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $account->email }}
                                        </x-table-cell>
                                        <x-table-cell>
                                            <a dusk="name" href="{{ route('account.show', $account->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $account->name }}</a>
                                        </x-table-cell>
                                        <x-table-cell>
                                            {{ ucWords($account->roles->first()->name) }}
                                        </x-table-cell>
                                        <x-table-cell>
                                            <a href="{{ route('account.edit', $account->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline"> {{ __('account.edit_title') }}</a>
                                        </x-table-cell>
                                        <x-table-cell>
                                            <form method="post" action="{{ route('account.destroy', $account->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <x-danger-button dusk="delete"> {{__('account.delete')}}</x-danger-button>
                                            </form>
                                        </x-table-cell>
                                    </x-table-row>
                                @endforeach
                            </tbody>
                        </x-table>
                        <div class="py-4 px-3">
                            {{ $accounts->links() }}
                        </div>
                    @else
                        <x-zero-results-section>{{__('account.null_results')}}</x-zero-results-section>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>