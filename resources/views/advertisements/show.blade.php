<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('advertisement.advertisements') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8 dark:bg-gray-800 dark:text-white flex gap-4">
                <div class="w-full">
                    <div class=" mt-4 max-w- w-full">
                        <img src="{{ $advertisement->image }}" alt="{{ $advertisement->title }}"
                            class="w-full h-full object-cover mb-4 rounded-md">
                    </div>
                    <p class="text-lg">{{ $advertisement->description }}</p>
                </div>
                <div class="mt-2 w-2/5 flex flex-col gap-4">
                    <h1 class="text-3xl font-bold">{{ $advertisement->title }}</h1>
                    <a href="{{ route('advertisements.index', $advertisement->seller->id) }}"
                        class="text-blue-500 hover:underline">{{ $advertisement->seller->name }}</a>
                    <span class="text-5xl">&euro;&nbsp;{{ $advertisement->price }}</span>
                    @if ($advertisement->delivery === 'pickup')
                        <span class="text-slate-400">{{ __('advertisement.pickup') }}</span>
                    @elseif ($advertisement->delivery === 'shipping')
                        <span class="text-slate-400">{{ __('advertisement.shipping') }}</span>
                    @elseif ($advertisement->delivery === 'pickup_shipping')
                        <span class="text-slate-400">{{ __('advertisement.pickup_and_shipping') }}</span>
                    @endif

                    @if ($advertisement->type === 'sell')
                        <button
                            class="bg-blue-500 text-white px-4 py-2 rounded-full">{{ __('advertisement.buy') }}</button>
                    @elseif ($advertisement->type === 'rental')
                        <button
                            class="bg-blue-500 text-white px-4 py-2 rounded-full">{{ __('advertisement.rent') }}</button>
                    @elseif ($advertisement->type === 'auction')
                        <!-- Show all biddings -->
                        <div class="mt-4">
                            <h2 class="text-xl font-bold">{{ __('advertisement.biddings') }}</h2>
                            <ul class="mt-2">
                                @foreach ($advertisement->bids as $bidding)
                                    <li class="flex justify-between">
                                        <span>{{ $bidding->user->name }}</span>
                                        <span>&euro;&nbsp;{{ $bidding->amount }}</span>
                                    </li>
                                @endforeach
                            </ul>

                            <form action="{{ route('advertisements.bid', [$advertisement->id]) }}" method="POST"
                                class="flex gap-4 justify-between">
                                @csrf
                                <input type="text" name="amount" class="mt-2 w-1/2" placeholder="Amount">
                                <button type="submit"
                                    class="bg-blue-500 text-white px-4 py-2 rounded-full mt-2">{{ __('advertisement.place_bid') }}</button>
                            </form>
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <p class="text-red-500">{{ $error }}</p>
                                @endforeach
                            @endif
                        </div>
                    @endif

                    <!-- Share QR code -->
                    <div class="relative group h-[340px]">
                        <span class="cursor-pointer underline text-blue-500">{{ __('advertisement.share') }}</span>
                        <div
                            class="absolute bg-white p-4 rounded shadow-md border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                            {{ QrCode::size(300)->generate(Request::url()) }}
                        </div>
                    </div>


                </div>
            </div>
</x-app-layout>
