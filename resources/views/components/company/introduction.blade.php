@props(['company'])

<div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div style="color: {{ \Color::fontColor($company->primary_color, 75); }}; background: linear-gradient(240deg, {{$company->primary_color}} 25%, {{$company->secondary_color}} 100%); "class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-lg">
                    <p>{{ $company->introduction_text }}</p>
                </div>
            </div>
        </div>