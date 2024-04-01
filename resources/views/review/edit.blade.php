<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('review.edit_title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-2 text-xl">
                        <h2> {{ __('review.title') }}</h2>
                    </div>
                    <div class="p-4 mb-4">
                        <form method="post" action="{{route('review.update', $review->id)}}">
                            @csrf
                            @method('PUT')
                            <div>
                                <textarea dusk="text" class="h-32 w-full" name="review">{{$review->review}}</textarea>
                                <x-input-error :messages="$errors->get('review')" class="mt-2" />
                            </div>
                            <div class="py-2">
                                <x-primary-button dusk="update">{{ __('review.update_button') }}</x-primary-button>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</x-app-layout>