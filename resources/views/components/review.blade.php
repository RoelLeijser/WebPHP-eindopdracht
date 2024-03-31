@props(['review'])  
    <div class="border border-gray-300 p-4 mb-4 rounded-lg w-full">
        <div class="grid grid-cols-2">
            <div>
                <h1><strong class="text-lg">{{$review->user->name}}</strong></h1>
                <span class="text-xs">{{$review->published_at->diffForHumans()}}</span>
            </div>
            @can('change review')
                <div class="flex justify-end space-x-3">
                    @if(Auth::check() && auth()->user()->id == $review->user_id)
                        <x-secondary-button class="h-8"><a href="{{route('review.edit', $review->id)}}">{{ __('review.update_button') }}</a></x-secondary-button>
                    @endif
                    @if(Auth::check() && auth()->user()->id == $review->user_id || auth()->user()->hasRole('admin'))
                        <form method="post" action="{{ route('review.destroy', $review->id) }}">
                            @csrf
                            @method('DELETE')
                            <x-danger-button dusk="delete"> {{__('review.delete_button')}}</x-danger-button>
                        </form>
                    @endif
                </div>
            @endcan
        </div>
        <div>
            <hr/>
            <p class="py-2">{{$review->review}}</p>
        </div>
    </div>