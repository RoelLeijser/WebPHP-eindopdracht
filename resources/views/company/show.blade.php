<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('company.title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-center">
                        <h1 class="text-xl">{{$company->name}}</h1>
                        <hr>
                    </div>
                    <div>
                       <!-- if statement for als niet ondertekent is dat het niet een eigen landingspagina kan creeeren. -->
                       <div>
                            <div class="py-2">
                                <h2>{{ __('company.slug') }}<span>{{$company->custom_url}}</span></h2>
                            </div>
                            <div class="py-2"> 
                                <h2>{{ __('company.font') }}<span>{{$company->font_style}}</span></h2>
                            </div>
                            <div class="py-2">
                                <h2>{{ __('company.color') }}<span>{{$company->color_modification}}</span></h2>
                            </div>
                            <div class="py-2">
                                <h2>{{ __('company.introduction_text') }}</h2>
                                <p class="border border-gray-200 mt-2 p-2">{{$company->introduction_text}}</p>
                            </div>
                            <div class="py-2">
                                <x-primary-button>{{ __('company.update_button') }}</x-primary-button>
                            </div>
                       </div>
                      <!-- <div class="flex justify-center py-3 text-red-600">
                            <h1> {{ __('company.contract_not_confirmed') }}</h1>
                       </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
