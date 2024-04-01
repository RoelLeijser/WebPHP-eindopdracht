<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('advertisement.advertisements') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($errors->any())
                        <div class="mb-3">
                            @foreach ($errors->all() as $error)
                                <div class="bg-red-300 border-red-950 text-red-800 p-4 rounded-lg mb-1">
                                    {{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                    <h1 class="text-2xl font-bold mb-6">{{ __('advertisement.import_csv_file') }}</h1>
                    <form class="flex flex-col w-1/3" method="post" action="{{ route('advertisements.storecsv') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input class="mb-3" type="file" name="file" accept=".csv" />
                        <button dusk="upload"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            type="submit">{{ __('advertisement.upload') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
