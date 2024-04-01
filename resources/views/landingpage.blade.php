<x-app-layout>
    <x-company.header :company="$company"/>
    

    @if(!is_null($company->layout))
        <div class="py-12 space-y-6" style="font-family: {{$company->font_style}}">
    
        <!-- uitgelichte advertenties  -->
            @if(!is_null($company->layout->first_component))
                <x-dynamic-component :component="'company.' . $company->layout->first_component" :adverts="$adverts" :company="$company" :reviews="$reviews" />
            @endif

            @if(!is_null($company->layout->second_component))
                <x-dynamic-component :component="'company.' . $company->layout->second_component" :adverts="$adverts" :company="$company" :reviews="$reviews"/>
            @endif

            @if(!is_null($company->layout->third_component))
                <x-dynamic-component :component="'company.' . $company->layout->third_component" :adverts="$adverts" :company="$company" :reviews="$reviews" />
            @endif
        </div>
    @endif


</x-app-layout>
