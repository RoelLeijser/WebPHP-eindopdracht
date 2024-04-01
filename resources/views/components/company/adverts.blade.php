@props(['company', 'reviews', 'adverts'])

<div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div style="color: {{ \Color::fontColor($company->primary_color, 75); }}; background: linear-gradient(240deg, {{$company->primary_color}} 25%, {{$company->secondary_color}} 100%); "class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h1 class="pb-3 text-3xl">{{ __('company.page.adverts') }}</h1>
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex flex-col gap-4">
                        @foreach ($adverts as $advert)
                            <x-advertisement :advertisement="$advert" />
                        @endforeach
                        {{ $adverts->links() }}
                    </div>
                </div>
            </div>
        </div>