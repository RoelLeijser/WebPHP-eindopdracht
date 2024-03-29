<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('company.title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-center">
                        <h1 class="text-xl">{{ $company->name }}</h1>
                    </div>
                    <div>
                        @can('contract accepted')
                            <div>
                                <div class="py-2">
                                    <h2 class="text-lg">
                                        <strong>{{ __('company.slug') }}</strong>
                                        @if (!is_null($company->slug))
                                            <a class="hover:text-blue-800"
                                                href="{{ route('landingpage', $company->slug) }}">{{ $company->slug }}</a>
                                    </h2>
                                    @endif
                                </div>
                                <div class="py-2">
                                    <h2 class="text-lg">
                                        <strong>{{ __('company.font') }}</strong><span>{{ $company->font_style }}</span>
                                    </h2>
                                </div>
                                <div class="py-2 content-center flex">
                                    <h2 class="text-lg"><strong>{{ __('company.color_primary') }}</strong></h2>
                                    <div style="background-color: {{ $company->primary_color }}"
                                        class="h-5 ml-1 rounded-md w-20"></div>
                                </div>
                                <div class="py-2 content-center flex">
                                    <h2 class="text-lg"><strong>{{ __('company.color_secondary') }}</strong></h2>
                                    <div style="background-color: {{ $company->secondary_color }}"
                                        class="h-5 ml-1 rounded-md w-20"></div>
                                </div>
                                <div class="py-2">
                                    <h2 class="text-lg"><strong>{{ __('company.introduction_text') }}</strong></h2>
                                    <p class="border border-gray-200 mt-2 p-2">{{ $company->introduction_text }}</p>
                                </div>
                                <div class="grid grid-cols-2">
                                    <div class="py-2">
                                        <a
                                            href="{{ route('company.edit', $company->id) }}"><x-primary-button>{{ __('company.update_button') }}</x-primary-button></a>
                                    </div>
                                    <div class="py-2 place-self-end py-2">
                                        <a
                                            href="{{ route('company.edit.layout', $company->id) }}"><x-primary-button>{{ __('company.layout_button') }}</x-primary-button></a>
                                    </div>
                                </div>

                            </div>
                        @endcan
                        @if (!auth()->user()->can('contract accepted'))
                            <div class="flex justify-center py-3 text-red-600">
                                <h1> {{ __('company.contract_not_confirmed') }}</h1>
                            </div>
                        @endif
                    </div>
                    <div class="py-2">
                        <h2 class="text-lg"><strong>{{ __('company.api_keys') }}</strong></h2>

                        <form class="flex gap-3" action="{{ route('company.createApiKey', $company->id) }}"
                            method="POST">
                            @csrf
                            <input type="text" name="name" class="border border-gray-200 w-full p-2"
                                placeholder="{{ __('company.create_api_key_placeholder') }}">
                            <x-primary-button type="submit">
                                {{ __('company.create_api_key_button') }}
                            </x-primary-button>
                        </form>
                        {{-- show errors  --}}
                        @if ($errors->name)
                            @foreach ($errors->all() as $error)
                                <span class="text-red-600">{{ $error }}</span>
                            @endforeach
                        @endif

                        @if (session('token'))
                            <div
                                class=" px-4 py-3 rounded relative my-4 flex
                                    bg-slack-50 border border-gray-200 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200
                                ">
                                <input type="text" class="border-0 w-full font-mono bg-transparent"
                                    value="{{ session('token') }}" readonly>
                                <button onclick={{ "navigator.clipboard.writeText('" . session('token') . "')" }}
                                    title="Copy">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" viewBox="0 0 448 512">
                                        <path
                                            d="M384 336H192c-8.8 0-16-7.2-16-16V64c0-8.8 7.2-16 16-16l140.1 0L400 115.9V320c0 8.8-7.2 16-16 16zM192 384H384c35.3 0 64-28.7 64-64V115.9c0-12.7-5.1-24.9-14.1-33.9L366.1 14.1c-9-9-21.2-14.1-33.9-14.1H192c-35.3 0-64 28.7-64 64V320c0 35.3 28.7 64 64 64zM64 128c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H256c35.3 0 64-28.7 64-64V416H272v32c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192c0-8.8 7.2-16 16-16H96V128H64z" />
                                    </svg>
                                </button>
                            </div>
                        @endif
                        <!-- show all tokens -->
                        <div class="py-2">
                            <div class="mt-2 p-2">
                                @foreach ($apiTokens as $apiToken)
                                    <div class="flex justify-start gap-4">
                                        <p class=w-full>{{ $apiToken->name }}</p>

                                        <form action="{{ route('company.deleteApiKey', $apiToken->id) }}"
                                            method="POST" class="flex">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="#ff3b3b" viewBox="0 0 512 512">
                                                    <path
                                                        d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM184 232H328c13.3 0 24 10.7 24 24s-10.7 24-24 24H184c-13.3 0-24-10.7-24-24s10.7-24 24-24z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
