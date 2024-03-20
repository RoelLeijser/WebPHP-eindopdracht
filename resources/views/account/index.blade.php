<x-app-layout>
   <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('account.title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if(session()->has('success'))
            <div id="flash" class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
                <div class="bg-green-400 dark:bg-green-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ session('success') }}
                    </div>
                </div>
            </div>
        @elseif(session()->has('error'))
            <div id="flash" class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
                <div class="bg-red-50 dark:bg-red-50 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ session('error') }}
                    </div>
                </div>
            </div>
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="py-3 w-48">
                        <form method="GET" class="flex w-80" action="#">
                            <input name="search" value="{{ request('search') }}" type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                            <button type="submit" class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
        </svg>
    </button>
                        </form>
                    </div>

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-center text-lg text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                    {{ __('account.email') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                    {{ __('account.name') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                    {{ __('account.role') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                    {{ __('account.actions') }}
                                    </th><th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($accounts as $account)
                                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                           {{ $account->email }}
                                        </th>
                                        <td class="px-6 py-4">
                                        {{ $account->name }}
                                        </td>
                                        <td class="px-6 py-4">
                                        {{ ucWords($account->role) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline"> {{ __('account.edit') }}</a>
                                        </td>
                                        <td class="px-6 py-4">
                                            <form method="post" action="{{ route('account.destroy', $account->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button dusk="delete" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded" type="submit">
                                                    {{__('account.delete')}}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="py-4 px-3">
                            {{ $accounts->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>