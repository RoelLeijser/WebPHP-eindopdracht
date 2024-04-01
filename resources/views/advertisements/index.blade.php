<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('advertisement.advertisements') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @can('create advertisements')
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="inline-flex rounded-md shadow-sm relative" role="group">

                        <a href="{{ route('advertisements.create') }}"
                            class="px-4 py-2 inline-flex font-bold text-white bg-blue-500 border border-blue-500 rounded-l-lg hover:bg-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" height="18" width="18"
                                fill="#fff" class="inline-block mr-2 my-auto">
                                <path
                                    d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                            </svg>
                            {{ __('advertisement.create_advertisement') }}
                        </a>
                        <button type="button" onclick="openDropdown()"
                            class="px-2 py-2 font-medium text-white bg-blue-500 border border-blue-500 rounded-r-md hover:bg-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="16" width="16"
                                fill="#fff">
                                <path
                                    d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z" />
                            </svg>
                        </button>
                        <div id="dropdown"
                            class="rounded-md shadow-md ring-1 ring-black ring-opacity-5 py-1 bg-white hidden absolute right-0 top-11">
                            <button class="py-2 px-4 flex flex-row hover:bg-slate-50">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="18" width="18"
                                    fill="#000" class="inline-block my-auto h-6 mr-2">
                                    <path
                                        d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V304H176c-35.3 0-64 28.7-64 64V512H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128zM200 352h16c22.1 0 40 17.9 40 40v8c0 8.8-7.2 16-16 16s-16-7.2-16-16v-8c0-4.4-3.6-8-8-8H200c-4.4 0-8 3.6-8 8v80c0 4.4 3.6 8 8 8h16c4.4 0 8-3.6 8-8v-8c0-8.8 7.2-16 16-16s16 7.2 16 16v8c0 22.1-17.9 40-40 40H200c-22.1 0-40-17.9-40-40V392c0-22.1 17.9-40 40-40zm133.1 0H368c8.8 0 16 7.2 16 16s-7.2 16-16 16H333.1c-7.2 0-13.1 5.9-13.1 13.1c0 5.2 3 9.9 7.8 12l37.4 16.6c16.3 7.2 26.8 23.4 26.8 41.2c0 24.9-20.2 45.1-45.1 45.1H304c-8.8 0-16-7.2-16-16s7.2-16 16-16h42.9c7.2 0 13.1-5.9 13.1-13.1c0-5.2-3-9.9-7.8-12l-37.4-16.6c-16.3-7.2-26.8-23.4-26.8-41.2c0-24.9 20.2-45.1 45.1-45.1zm98.9 0c8.8 0 16 7.2 16 16v31.6c0 23 5.5 45.6 16 66c10.5-20.3 16-42.9 16-66V368c0-8.8 7.2-16 16-16s16 7.2 16 16v31.6c0 34.7-10.3 68.7-29.6 97.6l-5.1 7.7c-3 4.5-8 7.1-13.3 7.1s-10.3-2.7-13.3-7.1l-5.1-7.7c-19.3-28.9-29.6-62.9-29.6-97.6V368c0-8.8 7.2-16 16-16z" />
                                </svg><a href="{{ route('advertisements.createcsv') }}">

                                    {{ __('advertisement.import_csv_file') }}
                                </a>
                            </button>
                        </div>
                    </div>
                </div>
            @endcan

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex flex-col gap-2">
                <!-- filter -->
                <div class="flex">
                    <form action="{{ route('advertisements.index') }}" method="GET"
                        class="flex justify-between w-full">
                        <div class="flex gap-2">
                            <div class="flex flex-col">
                                <label for="filter[title]">{{ __('advertisement.title') }}</label>
                                <input type="text" name="filter[title]" id="filter[title]"
                                    value="{{ request()->input('filter.title') }}"
                                    class="p-2 border border-gray-300 dark:border-gray-700 rounded">
                            </div>
                            <div class="flex flex-col w-full">
                                <label for="filter[type]">{{ __('advertisement.type') }}</label>
                                <select name="filter[type]" id="filter[type]"
                                    class="p-2 border border-gray-300 dark:border-gray-700 rounded inline-block w-32">
                                    <option value=""></option>
                                    <option value="sell" @if (request()->input('filter.type') == 'sell') selected @endif>
                                        {{ __('advertisement.for_sale') }}</option>
                                    <option value="rental" @if (request()->input('filter.type') == 'rental') selected @endif>
                                        {{ __('advertisement.for_rent') }}</option>
                                    <option value="auction" @if (request()->input('filter.type') == 'auction') selected @endif>
                                        {{ __('advertisement.auction') }}</option>
                                </select>
                            </div>
                            <div class="flex flex-col">
                                <label for="filter[delivery]">{{ __('advertisement.delivery') }}</label>
                                <select name="filter[delivery]" id="filter[delivery]"
                                    class="p-2 border border-gray-300 dark:border-gray-700 rounded inline-block w-32">
                                    <option value=""></option>
                                    <option value="pickup" @if (request()->input('filter.delivery') == 'pickup') selected @endif>
                                        {{ __('advertisement.pickup') }}</option>
                                    <option value="shipping" @if (request()->input('filter.delivery') == 'shipping') selected @endif>
                                        {{ __('advertisement.shipping') }}</option>
                                </select>
                            </div>
                            <div class="flex flex-col">
                                <label for="filter[price]">{{ __('advertisement.min_price') }}</label>
                                <input type="text" name="filter[price][]" id="filter[price]"
                                    value="{{ request()->input('filter.price.0') ?: $price[0] }}"
                                    class="p-2 border border-gray-300 dark:border-gray-700 rounded w-24" default="0">
                            </div>
                            <div class="flex flex-col">
                                <label for="filter[price]">{{ __('advertisement.max_price') }}</label>
                                <input type="text" name="filter[price][]" id="filter[price]"
                                    value="{{ request()->input('filter.price.1') ?: $price[1] }}"
                                    class="p-2 border border-gray-300 dark:border-gray-700 rounded w-24">
                            </div>

                            <div class="flex flex-col justify-end">
                                <x-primary-button class="h-10"
                                    type="submit">{{ __('general.filter') }}</x-primary-button>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <label for="sort">{{ __('general.sort') }}</label>
                            <select name="sort" id="sort"
                                class="p-2 border border-gray-300 dark:border-gray-700 rounded inline-block w-44"
                                onchange="this.form.submit()">
                                <option value="-created_at" @if (request()->input('sort') == '-created_at') selected @endif>
                                    {{ __('general.newest') }}</option>
                                <option value="created_at" @if (request()->input('sort') == 'created_at') selected @endif>
                                    {{ __('general.oldest') }}</option>
                                <option value="price" @if (request()->input('sort') == 'price') selected @endif>
                                    {{ __('advertisement.price_asc') }}</option>
                                <option value="-price" @if (request()->input('sort') == '-price') selected @endif>
                                    {{ __('advertisement.price_desc') }}</option>
                            </select>
                        </div>
                    </form>
                </div>
                @if ($advertisements->count())
                    @foreach ($advertisements as $advertisement)
                        <x-advertisement :advertisement="$advertisement" />
                    @endforeach
                @else
                    <p class="mx-auto mt-10">{{ __('advertisement.no_advertisements') }}</p>
                @endif
                {{ $advertisements->links() }}
            </div>
        </div>
    </div>

    <script>
        function openDropdown() {
            document.getElementById("dropdown").classList.toggle("hidden");
        }
    </script>
</x-app-layout>
