@props(['advertisement', 'id', 'route'])

<div class="p-2 text-xl">
    <h2> {{ __('review.title') }}</h2>
</div>
 <div class="p-4 mb-4">
    <form method="post" action="{{route($route, $id)}}">
        @csrf
        <div>
            <textarea class="h-32 w-full" name="review"></textarea>
            <x-input-error :messages="$errors->get('review')" class="mt-2" />
        </div>
        <div class="py-2">
            <x-primary-button>{{ __('review.create_button') }}</x-primary-button>
        </div>
    </form>
</div>