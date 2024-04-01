<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('advertisement.create_advertisement') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                @if ($errors->any())
                    <div class="bg-red-500 dark:bg-red-600 text-white p-4 rounded-lg mb-6">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('advertisements.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-col gap-4">
                        <div class="flex flex-col gap-2">
                            <label for="title"
                                class="text-sm text-gray-600 dark:text-gray-300">{{ __('advertisement.title') }}</label>
                            <input dusk="title" type="text" name="title" id="title"
                                class="p-2 border border-gray-300 dark:border-gray-700 rounded-lg">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="image"
                                class="text-sm text-gray-600 dark:text-gray-300">{{ __('advertisement.image') }}</label>
                            <input dusk="file" type="file" name="image" id="image" accept="image/*"
                                class="p-2 border border-gray-300 dark:border-gray-700 rounded-lg" required>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="description"
                                class="text-sm text-gray-600 dark:text-gray-300">{{ __('advertisement.description') }}</label>
                            <textarea dusk="description" name="description" id="description" class="p-2 border border-gray-300 dark:border-gray-700 rounded-lg"
                                required></textarea>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="price"
                                class="text-sm text-gray-600 dark:text-gray-300">{{ __('advertisement.price') }}</label>
                            <input dusk="price" type="number" min=0 name="price" id="price"
                                class="p-2 border border-gray-300 dark:border-gray-700 rounded-lg" required>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="type"
                                class="text-sm text-gray-600 dark:text-gray-300">{{ __('advertisement.type') }}</label>
                            <div class="flex gap-4">
                                <div class="flex items-center">
                                    <input dusk="type" type="radio" name="type" id="sell" value="sell" class="mr-2">
                                    <label for="sell"
                                        class="text-sm text-gray-600 dark:text-gray-300">{{ __('advertisement.sell') }}</label>
                                </div>
                                <div class="flex items-center">
                                    <input dusk="type" type="radio" name="type" id="rental" value="rental" class="mr-2">
                                    <label for="rental"
                                        class="text-sm text-gray-600 dark:text-gray-300">{{ __('advertisement.rent') }}</label>
                                </div>
                                <div class="flex items-center">
                                    <input dusk="type" type="radio" name="type" id="auction" value="auction" class="mr-2">
                                    <label for="auction"
                                        class="text-sm text-gray-600 dark:text-gray-300">{{ __('advertisement.auction') }}</label>
                                </div>
                            </div>

                            <label for="delivery"
                                class="text-sm text-gray-600 dark:text-gray-300">{{ __('advertisement.delivery') }}</label>
                            <select dusk="delivery" name="delivery" id="delivery"
                                class="p-2 border border-gray-300 dark:border-gray-700 rounded-lg" required>
                                <option value="pickup_shipping" default>{{ __('advertisement.pickup_and_shipping') }}
                                </option>
                                <option value="shipping">{{ __('advertisement.shipping') }}</option>
                                <option value="pickup">{{ __('advertisement.pickup') }}</option>
                            </select>

                            <button dusk="create" type="submit"
                                class="bg-blue-500 dark:bg-blue-600 hover:bg-blue-700 dark:hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">{{ __('advertisement.create_advertisement') }}</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
