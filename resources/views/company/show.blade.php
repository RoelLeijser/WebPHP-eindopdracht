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
                                <h2 class="text-lg"><strong>{{ __('company.slug') }}</strong><span>{{$company->custom_url}}</span></h2>
                            </div>
                            <div class="py-2"> 
                                <h2 class="text-lg"><strong>{{ __('company.font') }}</strong><span>{{$company->font_style}}</span></h2>
                            </div>
                            <div class="py-2 content-center flex">
                                <h2 class="text-lg"><strong>{{ __('company.color') }}</strong></h2>
                                <div style="background-color: {{$company->color_modification}}" class="h-5 ml-1 rounded-md w-20"></div>
                            </div>
                            <div class="py-2">
                                <h2 class="text-lg"><strong>{{ __('company.introduction_text') }}</strong></h2>
                                <p class="border border-gray-200 mt-2 p-2">{{$company->introduction_text}}</p>
                            </div>
                            <div class="py-2">
                                <a href="{{route('company.edit', $company->id)}}"><x-primary-button>{{ __('company.update_button') }}</x-primary-button></a>
                            </div>
                       </div>
                       <!-- TODO: add permission -->
                      <!-- <div class="flex justify-center py-3 text-red-600">
                            <h1> {{ __('company.contract_not_confirmed') }}</h1>
                       </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
