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
                    @if (auth()->user()->id === $advertisement->seller->id)
                        <div class="flex gap-2">
                            @can('edit advertisements')
                                <a href="{{ route('advertisements.edit', [$advertisement->id]) }}"
                                    class="bg-blue-500 text-white px-4 py-2 rounded-full mt-2 inline-flex gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16"
                                        height="16" fill="#fff" class="my-auto">
                                        <path
                                            d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                                    </svg>
                                    {{ __('advertisement.edit_advertisement') }}
                                </a>
                            @endcan
                            @can('delete advertisements')
                                <form action="{{ route('advertisements.destroy', [$advertisement->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-white px-4 py-2 rounded-full mt-2 inline-flex gap-2"
                                        onclick="return confirm(
                                            '{{ __('advertisement.delete_confirmation') }}'
                                        )">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16"
                                            height="16" fill="#fff" class="my-auto">
                                            <path
                                                d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                                        </svg>
                                        {{ __('advertisement.delete_advertisement') }}
                                    </button>
                                </form>
                            @endcan
                        </div>
                    @endif
                </div>
                <div class="mt-2 w-2/5 flex flex-col gap-4">
                    <!-- favorite button -->
                    @can('favorite advertisements')
                        <form action="{{ route('advertisements.favorite', [$advertisement->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="p-2 rounded-full fill-black bg-slate-100 inline-block mt-2"
                                title="Favorite">
                                @if ($isFavorite)
                                    <!-- Show filled heart icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24"
                                        height="24" fill="#ff3b3b">
                                        <path
                                            d="M47.6 300.4L228.3 469.1c7.5 7 17.4 10.9 27.7 10.9s20.2-3.9 27.7-10.9L464.4 300.4c30.4-28.3 47.6-68 47.6-109.5v-5.8c0-69.9-50.5-129.5-119.4-141C347 36.5 300.6 51.4 268 84L256 96 244 84c-32.6-32.6-79-47.5-124.6-39.9C50.5 55.6 0 115.2 0 185.1v5.8c0 41.5 17.2 81.2 47.6 109.5z" />
                                    </svg>
                                @else
                                    <!-- Show empty heart icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24"
                                        height="24" fill="#ff3b3b">
                                        <path
                                            d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z" />
                                    </svg>
                                @endif
                            </button>
                        </form>
                    @endcan


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

                            @can('bid advertisements')
                                <form action="{{ route('advertisements.bid', [$advertisement->id]) }}" method="POST"
                                    class="flex gap-4 justify-between">
                                    @csrf
                                    <input type="text" name="amount" class="mt-2 w-1/2">
                                    <button type="submit"
                                        class="bg-blue-500 text-white px-4 py-2 rounded-full mt-2">{{ __('advertisement.place_bid') }}</button>
                                </form>
                                @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                        <p class="text-red-500">{{ $error }}</p>
                                    @endforeach
                                @endif
                            @endcan

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
