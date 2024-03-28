@props(['company'])

<header style="background: linear-gradient(240deg, {{$company->primary_color}} 25%, {{$company->secondary_color}} 100%); " class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl space-x-3 flex justify-center mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @if(!is_null($company->logo))
            <div>
                <img class="h-16 rounded-full w-16" src="{{ asset('storage/' . $company->logo)}}">
            </div>
        @endif
        <div class="content-center">
            <h2 style="font-family: {{$company->font_style}}; color: {{ \Color::fontColor($company->primary_color, 75); }};" class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{$company->name}}
            </h2>
        </div>
        </div>
    </header>