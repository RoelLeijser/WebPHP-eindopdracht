<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('advertisement.advertisements') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex flex-col gap-4">
                @foreach ($advertisements as $advertisement)
                    <x-advertisement :advertisement="$advertisement" />
                @endforeach
                {{ $advertisements->links() }}
            </div>
        </div>
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-3">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8 dark:bg-gray-800 dark:text-white gap-4">
                        @can('create review')
                            <x-review-create route="review.store.user" :id="$advertisement->seller_id" :advertisement="$advertisement"></x-review-create>
                        @endcan
                           
                        @foreach($reviews as $review)
                            <x-review  :review="$review"/>
                        @endforeach
                        <div class="py-4 px-3">
                            <hr class="py-1"/>
                            {{ $reviews->links() }}
                        </div>
                </div>
            </div>

    </div>
</x-app-layout>
