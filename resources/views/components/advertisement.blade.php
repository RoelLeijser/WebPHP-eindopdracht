 <div class="flex">
     <div class="flex p-3 w-full relative">
         <a href="{{ route('advertisements.show', $advertisement->id) }}" class="absolute inset-0 z-10"></a>
         <img src="{{ $advertisement->image }}" alt="{{ $advertisement->title }}"
             class="w-48 h-40 rounded-lg min-w-48 object-cover">

         <div class="flex justify-between w-full">
             <div class="flex flex-col ml-3 justify-between">
                 <div>
                     <div class="mb-1">
                         <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                             {{ $advertisement->title }}</h2>
                         <span class="text-sm text-gray-500 dark:text-gray-400">
                             @if ($advertisement->type == 'sell')
                                 {{ __('advertisement.for_sale') }}
                             @elseif ($advertisement->type == 'rental')
                                 {{ __('advertisement.for_rent') }}
                             @elseif ($advertisement->type == 'auction')
                                 {{ __('advertisement.auction') }}
                             @endif
                         </span>
                     </div>
                     <p class="max-w-2xl text-gray-600 dark:text-gray-300">
                         {{ $advertisement->description }}</p>
                 </div>

                 @if ($advertisement->delivery == 'pickup')
                     <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('advertisement.pickup') }}</span>
                 @elseif ($advertisement->delivery == 'shipping')
                     <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('advertisement.shipping') }}</span>
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
    <div class="w-full max-w-40 p-3">
        <a href="{{ route('advertisements.user', $advertisement->seller_id) }}"
            class="text-blue-500 dark:text-blue-400 hover:underline  whitespace-nowrap">
            {{ \Illuminate\Support\Str::limit($advertisement->seller->name, 16, $end = '...') }}
        </a>
        @if(!is_null($advertisement->seller->company))
            <span>{{__('advertisement.company')}}<a href="{{ route('landingpage', $advertisement->seller->company->slug) }}"
                class="text-blue-500 dark:text-blue-400 hover:underline  whitespace-nowrap">
                {{ \Illuminate\Support\Str::limit($advertisement->seller->company->name, 16, $end = '...') }}
            </a></span>
        @endif
    </div>
 </div>
