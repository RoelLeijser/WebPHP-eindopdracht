<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('company.layout_update') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form class="w-full" method="post" action="{{route('company.update.layout', $layout->id)}}">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-2">
                                <div class="py-2 px-2">
                                    <x-input-label>{{ __('company.first_component') }}</x-input-label>
                                    <select dusk="first" name="first" class="block mt-1 w-full rounded">
                                        <option value="">{{ __('general.none_option') }}</option>
                                        @foreach($components as $component)
                                            <option value="{{$component}}" {{ $layout->first_component == $component ? 'selected' : '' }}>{{ucWords($component)}}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('first')" class="mt-2" />
                                </div>
                                <div class="py-2 px-2">
                                    <x-input-label>{{ __('company.second_component') }}</x-input-label>
                                    <select dusk="second" name="second" class="block mt-1 w-full rounded">
                                        <option value="">{{ __('general.none_option') }}</option>
                                        @foreach($components as $component)
                                            <option value="{{$component}}" {{ $layout->second_component == $component ? 'selected' : '' }}>{{ucWords($component)}}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('second')" class="mt-2" />
                                </div>
                                <div class="py-2 px-2">
                                    <x-input-label>{{ __('company.third_component') }}</x-input-label>
                                    <select dusk="third" name="third" class="block mt-1 w-full rounded">
                                        <option value="">{{ __('general.none_option') }}</option>
                                        @foreach($components as $component)
                                            <option value="{{$component}}" {{ $layout->third_component == $component ? 'selected' : '' }}>{{ucWords($component)}}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('third')" class="mt-2" />
                                </div>
                            </div>
                            <div class="py-2 px-2">
                                    <x-primary-button dusk="update">{{ __('company.layout_button') }}</x-primary-button>
                                </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
