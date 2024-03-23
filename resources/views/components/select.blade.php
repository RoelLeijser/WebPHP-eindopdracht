<select {{ $attributes->merge(['class' => 'appearance-none bg-white block border border-gray-400 focus:outline-none focus:shadow-outline hover:border-gray-500 leading-tight pr-10 px-4 py-2 rounded shadow']) }} {{isset($onchange) ? 'onchange=' . $onchange : ''}}>
    {{$slot}}
</select>