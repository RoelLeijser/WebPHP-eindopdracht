<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('account.favorites') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex flex-col gap-4">
                <!-- index list all favorite advertisements -->
                @if ($advertisements->count() > 0)
                    @foreach ($advertisements as $advertisement)
                        <x-advertisement :advertisement="$advertisement" />
                    @endforeach
                    {{ $advertisements->links() }}
                @else
                    <p class="mx-auto">{{ __('account.no_favorites') }}</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
