<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('advertisement.advertisement') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8 dark:bg-gray-800 dark:text-white flex gap-4">
                <div class="">
                    <div class="mt-4 max-w-3xl w-full">
                        <img src=" {{ $advertisement->image }}" alt="{{ $advertisement->title }}" class="w-full h-full object-cover mb-4">
                    </div>
                    <p class="text-lg">{{ $advertisement->description }}</p>
                </div>
                <div class="mt-2 w-full flex flex-col gap-4">
                    <h1 class="text-3xl font-bold">{{ $advertisement->title }}</h1>
                    <a href="{{ route('advertisements.index', $advertisement->seller->id) }}" class="text-blue-500 hover:underline">{{ $advertisement->seller->name }}</a>
                    <span class="text-5xl">&euro;&nbsp;{{ $advertisement->price }}</span>
                    @if ($advertisement->delivery === 'pickup')
                    <span class="text-slate-400">{{__('advertisement.pickup')}}</span>
                    @elseif ($advertisement->delivery === 'shipping')
                    <span class="text-slate-400">{{__('advertisement.shipping')}}</span>
                    @elseif ($advertisement->delivery === 'pickup_shipping')
                    <span class="text-slate-400">{{__('advertisement.pickup_and_shipping')}}</span>
                    @endif

                    @if ($advertisement->type === 'sell')
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-full">Buy</button>
                    @elseif ($advertisement->type === 'rental')
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-full">Rent</button>
                    @endif
                </div>
            </div>
        </div>
</x-app-layout>