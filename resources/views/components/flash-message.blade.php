<div id="flash" class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
    <div {{ $attributes->merge(['class' => 'overflow-hidden shadow-sm sm:rounded-lg']) }}>
        <div class="p-6 text-gray-900 dark:text-gray-100">
            {{ $slot }}
        </div>
    </div>
</div>