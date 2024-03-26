<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('company.edit_title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form class="w-full" method="post" action="{{route('company.update', $company->id)}}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="grid grid-cols-2">
                                <div class="py-2 px-2">
                                    <x-input-label class="py-2" for="name" :value="__('company.name')" />
                                    <x-text-input class="w-full" name="name" :value="$company->name" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                                <div class="py-2 px-2">
                                    <x-input-label class="py-2" for="slug" :value="__('company.slug')" />
                                    <x-text-input class="w-full" name="slug" :value="$company->slug" />
                                    <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                                </div>
                            </div>
                            <div class="grid grid-cols-3">
                                <div class="py-2 px-2">
                                    <x-input-label class="py-2" for="font" :value="__('company.font')" />
                                    <x-text-input class="w-full" name="font" :value="$company->font_style" />
                                    <x-input-error :messages="$errors->get('font')" class="mt-2" />
                                </div>
                                <div class="py-2 px-2">
                                    <x-input-label class="py-2" for="color" :value="__('company.color_primary')" />
                                    <input type="color" name="primary_color" value="{{$company->primary_color}}"/>
                                    <x-input-error :messages="$errors->get('primary_color')" class="mt-2" />
                                </div>
                                <div class="py-2 px-2">
                                    <x-input-label class="py-2" for="color" :value="__('company.color_secondary')" />
                                    <input type="color" name="secondary_color" value="{{$company->secondary_color}}"/>
                                    <x-input-error :messages="$errors->get('secondary_color')" class="mt-2" />
                                </div>
                                <div class="py-2 px-2">
                                    <x-input-label class="py-2" for="logo" :value="__('company.logo')" />
                                    <input type="file" name="logo" value="{{$company->logo}}"/>
                                    <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                                </div>
                                @if(!is_null($company->logo))
                                <div class="flex justify-center px-2 py-2 rounded-md">
                                    <img class="h-16 rounded-full w-16" src="{{ asset('storage/' . $company->logo)}}">
                                </div>
                                @endif
                            </div>
                            <div>
                                <div class="py-2 px-2">
                                    <x-input-label class="py-2" for="introduction" :value="__('company.introduction_text')" />
                                    <textarea name="introduction" class="h-32 w-full">{{$company->introduction_text}}</textarea>
                                    <x-input-error :messages="$errors->get('introduction')" class="mt-2" />
                                </div>
                                <div class="py-2 px-2">
                                    <x-primary-button>{{ __('company.update_button') }}</x-primary-button>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
