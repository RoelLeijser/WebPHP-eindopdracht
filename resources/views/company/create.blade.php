<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('company.title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="lg:px-8 max-w-xl mx-auto sm:px-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('company.store') }}">
                        @csrf
                        <div>
                            <x-input-label for="name" :value="__('company.name')" />
                            <x-text-input dusk="name" id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="flex justify-center mt-4">
                            <x-primary-button  dusk="create" class="ms-4">
                                {{ __('company.create') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
