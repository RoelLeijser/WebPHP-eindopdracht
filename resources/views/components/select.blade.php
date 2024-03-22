<select {{ $attributes->merge(['class' => 'w-full appearance-none bg-white block border border-gray-400 focus:outline-none focus:shadow-outline hover:border-gray-500 leading-tight pr-10 px-4 py-2 rounded shadow w-40']) }} {{isset($onchange) ? 'onchange=' . $onchange : ''}}>
    {{$slot}}
</select>