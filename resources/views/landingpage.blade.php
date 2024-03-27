<x-app-layout>
    <x-company.header :company="$company"/>
    
    <div class="py-12 space-y-6" style="font-family: {{$company->font_style}}">
    
        <!-- uitgelichte advertenties  -->
        @if(!is_null($company->layout->first_component))
            <x-dynamic-component :component="'company.' . $company->layout->first_component" :company="$company" />
        @endif

        @if(!is_null($company->layout->second_component))
            <x-dynamic-component :component="'company.' . $company->layout->second_component" :company="$company" />
        @endif

        @if(!is_null($company->layout->third_component))
            <x-dynamic-component :component="'company.' . $company->layout->third_component" :company="$company" />
        @endif
    </div>


</x-app-layout>
