<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('account.agenda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200 flex flex-col gap-5">
                    <h1 class="text-2xl font-semibold">{{ __('advertisement.rented_out') }}</h1>
                    @if ($rentedProducts->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th
                                        class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('advertisement.title') }}
                                    </th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('advertisement.rented_out_to') }}
                                    </th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('advertisement.until') }}
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($rentedProducts as $product)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-no-wrap">
                                            <a href="{{ route('advertisements.show', $product->id) }}"
                                                class="text-sm leading-5 text-gray-900 underline">
                                                {{ $product->title }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap">
                                            <div class="text-sm leading-5 text-gray-900">
                                                {{ $product->renter->first()->name }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap">
                                            <div class="text-sm leading-5 text-gray-900">
                                                {{ $product->renter->first()->pivot->end_date }}</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-sm leading-5 text-gray-900">
                            {{ __('account.no_rented_products') }}
                        </div>
                    @endif
                    <hr class="my-5">
                    <h1 class="text-2xl font-semibold">{{ __('advertisement.my_advertisements') }}</h1>

                    @if ($advertisements->count() > 0)

                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th
                                        class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('advertisement.title') }}
                                    </th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('advertisement.end_date') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($advertisements as $advertisement)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-no-wrap">
                                            <a href="{{ route('advertisements.show', $advertisement->id) }}"
                                                class="text-sm leading-5 text-gray-900 underline">
                                                {{ $advertisement->title }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap">
                                            <div class="text-sm leading-5 text-gray-900">{{ $advertisement->end_date }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-sm leading-5 text-gray-900">
                            {{ __('account.no_advertisements') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
