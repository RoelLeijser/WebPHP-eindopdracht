<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('advertisement.advertisements') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <a href="{{ route('advertisements.create') }}"
                        class="bg-blue-500 dark:bg-blue-600 hover:bg-blue-700 dark:hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">Create
                        Advertisement</a>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex flex-col gap-4">
                @foreach ($advertisements as $advertisement)
                    <div class="flex">
                        <div class="flex p-3 w-full relative">
                            <a href="{{ route('advertisements.show', $advertisement->id) }}"
                                class="absolute inset-0 z-10"></a>
                            <img src="{{ $advertisement->image }}" alt="{{ $advertisement->title }}"
                                class="w-48 h-40 rounded-lg min-w-48 object-cover">

                            <div class="flex justify-between w-full">
                                <div class="flex flex-col ml-3 justify-between">
                                    <div>
                                        <div class="mb-1">
                                            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                                                {{ $advertisement->title }}</h2>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $advertisement->type == 'sell' ? __('advertisement.for_sale') : __('advertisement.for_rent') }}
                                            </span>
                                        </div>
                                        <p class="max-w-2xl text-gray-600 dark:text-gray-300">
                                            {{ $advertisement->description }}</p>
                                    </div>

                                    @if ($advertisement->delivery == 'pickup')
                                        <span
                                            class="text-sm text-gray-500 dark:text-gray-400">{{ __('advertisement.pickup') }}</span>
                                    @elseif ($advertisement->delivery == 'shipping')
                                        <span
                                            class="text-sm text-gray-500 dark:text-gray-400">{{ __('advertisement.shipping') }}</span>
                                    @elseif ($advertisement->delivery == 'pickup_shipping')
                                        <span
                                            class="text-sm text-gray-500 dark:text-gray-400">{{ __('advertisement.pickup_and_shipping') }}</span>
                                    @endif
                                </div>
                                <div class="flex gap-3 max-w-52">
                                    <div class="flex flex-col">
                                        <data value="{{ $advertisement->price }}"
                                            class="text-lg font-bold text-gray-800 dark:text-gray-200">&euro;&nbsp;{{ $advertisement->price }}</data>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            @if ($advertisement->created_at->isToday())
                                                {{ __('general.today') }}
                                            @elseif ($advertisement->created_at->isYesterday())
                                                {{ __('general.yesterday') }}
                                            @else
                                                {{ $advertisement->created_at->format('d/m/Y') }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('advertisements.index') }}"
                            class="text-blue-500 dark:text-blue-400 hover:underline w-full max-w-40 p-3 whitespace-nowrap">
                            {{ \Illuminate\Support\Str::limit($advertisement->seller->name, 16, $end = '...') }}
                        </a>
                    </div>
                @endforeach
                {{ $advertisements->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
