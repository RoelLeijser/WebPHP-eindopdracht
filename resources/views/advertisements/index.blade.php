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
                    <div class="max-w-xl">
                        <a href="{{ route('advertisements.create') }}"
                            class="bg-blue-500 dark:bg-blue-600 hover:bg-blue-700 dark:hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
                            {{ __('advertisement.create_advertisement') }}
                        </a>
                    </div>
                </div>
            @endcan

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex flex-col gap-4">
                <!-- filter -->
                <div class="flex justify-between">
                    <form action="{{ route('advertisements.index') }}" method="GET" class="flex gap-4 justify-end">
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
                                class="p-2 border border-gray-300 dark:border-gray-700 rounded" default="0">
                        </div>
                        <div class="flex flex-col">
                            <label for="filter[price]">{{ __('advertisement.max_price') }}</label>
                            <input type="text" name="filter[price][]" id="filter[price]"
                                value="{{ request()->input('filter.price.1') ?: $price[1] }}"
                                class="p-2 border border-gray-300 dark:border-gray-700 rounded">
                        </div>

                        <div class="flex flex-col justify-end">
                            <x-primary-button class="h-10"
                                type="submit">{{ __('general.filter') }}</x-primary-button>
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
</x-app-layout>
