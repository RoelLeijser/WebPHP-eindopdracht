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
                    </div>
                    <div>
                        @can('contract accepted')
                            <div>
                                <div class="py-2">
                                    <h2 class="text-lg">
                                        <strong>{{ __('company.slug') }}</strong>
                                    @if(!is_null($company->slug))
                                        <a class="hover:text-blue-800" href="{{route('landingpage', $company->slug)}}">{{$company->slug}}</a></h2>
                                    @endif
                            </div>
                            <div class="py-2"> 
                                <h2 class="text-lg"><strong>{{ __('company.font') }}</strong><span>{{$company->font_style}}</span></h2>
                            </div>
                            <div class="py-2 content-center flex">
                                <h2 class="text-lg"><strong>{{ __('company.color_primary') }}</strong></h2>
                                <div style="background-color: {{$company->primary_color}}" class="h-5 ml-1 rounded-md w-20"></div>
                            </div>
                            <div class="py-2 content-center flex">
                                <h2 class="text-lg"><strong>{{ __('company.color_secondary') }}</strong></h2>
                                <div style="background-color: {{$company->secondary_color}}" class="h-5 ml-1 rounded-md w-20"></div>
                            </div>
                            <div class="py-2">
                                <h2 class="text-lg"><strong>{{ __('company.introduction_text') }}</strong></h2>
                                <p class="border border-gray-200 mt-2 p-2">{{$company->introduction_text}}</p>
                            </div>
                            <div class="grid grid-cols-2">
                                <div class="py-2">
                                    <a href="{{route('company.edit', $company->id)}}"><x-primary-button>{{ __('company.update_button') }}</x-primary-button></a>
                                </div>
                                <div class="py-2 place-self-end py-2">
                                    <a href="{{route('company.edit.layout', $company->id)}}"><x-primary-button>{{ __('company.layout_button') }}</x-primary-button></a>
                                </div>
                            </div>

                            </div>
                        @endcan
                        @if(!auth()->user()->can('contract accepted'))
                            <div class="flex justify-center py-3 text-red-600">
                                <h1> {{ __('company.contract_not_confirmed') }}</h1>
                            </div>
                       @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
