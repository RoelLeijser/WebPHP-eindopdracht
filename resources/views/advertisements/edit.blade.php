<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('advertisement.edit_advertisement') }}
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
                <form action="{{ route('advertisements.update', $advertisement->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-col gap-4">
                        <div class="flex flex-col gap-2">
                            <label for="title" class="text-sm text-gray-600 dark:text-gray-300">{{ __('advertisement.title') }}</label>
                            <input type="text" name="title" id="title" class="p-2 border border-gray-300 dark:border-gray-700 rounded-lg" value="{{ $advertisement->title }}" required>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="image" class="text-sm text-gray-600 dark:text-gray-300">{{ __('advertisement.image') }}</label>
                            <input type="file" name="image" id="image" accept="image/*" class="p-2 border border-gray-300 dark:border-gray-700 rounded-lg">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="description" class="text-sm text-gray-600 dark:text-gray-300">{{ __('advertisement.description') }}</label>
                            <textarea name="description" id="description" class="p-2 border border-gray-300 dark:border-gray-700 rounded-lg" required>{{ $advertisement->description }}</textarea>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="price" class="text-sm text-gray-600 dark:text-gray-300">{{ __('advertisement.price') }}</label>
                            <input type="text" name="price" id="price" class="p-2 border border-gray-300 dark:border-gray-700 rounded-lg" value="{{ $advertisement->price }}" required>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="type" class="text-sm text-gray-600 dark:text-gray-300">{{ __('advertisement.type') }}</label>
                            <div class="flex gap-4">
                                <div class="flex items-center">
                                    <input type="radio" name="type" id="sell" value="sell" class="mr-2" required {{ $advertisement->type === 'sell' ? 'checked' : '' }}>
                                    <label for="sell" class="text-sm text-gray-600 dark:text-gray-300">{{ __('advertisement.sell') }}</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" name="type" id="rental" value="rental" class="mr-2" required {{ $advertisement->type === 'rental' ? 'checked' : '' }}>
                                    <label for="rental" class="text-sm text-gray-600 dark:text-gray-300">{{ __('advertisement.rent') }}</label>
                                </div>
                            </div>
                        </div>

                        <label for="delivery" class="text-sm text-gray-600 dark:text-gray-300">{{ __('advertisement.delivery') }}</label>
                        <select name="delivery" id="delivery" class="p-2 border border-gray-300 dark:border-gray-700 rounded-lg" required>
                            <option value="pickup_shipping" {{ $advertisement->delivery === 'pickup_shipping' ? 'selected' : '' }}>{{ __('advertisement.pickup_and_shipping') }}</option>
                            <option value="shipping" {{ $advertisement->delivery === 'shipping' ? 'selected' : '' }}>{{ __('advertisement.shipping') }}</option>
                            <option value="pickup" {{ $advertisement->delivery === 'pickup' ? 'selected' : '' }}>{{ __('advertisement.pickup') }}</option>
                        </select>

                        <button type="submit" class="bg-blue-500 dark:bg-blue-600 hover:bg-blue-700 dark:hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">{{ __('advertisement.update_advertisement') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>