<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Chirps') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <form method="POST" action="{{ route('chirps.store') }}">
                        @csrf
                        <textarea name="message"
                                    class="block w-full rounded-md border-gray-300 bg-white shadow-sm transition-colors duration-75 dark:bg-gray-900"
                                    placeholder="{{__('What\'s on your mind?')}}"
                        >{{old('message')}}</textarea>
                        <x-input-error :messages="$errors->get('message')"
                            class="mt-2"/>
                        <x-primary-button class="mt-4">
                            {{__("Chirp")}}
                        </x-primary-button>
                    </form>

                </div>
            </div>

            <div class="mt-6 bg-white dark:bg-gray-800 shadow-sm rounded-lg divide-y dark:divide-gray-900">
                @foreach ($chirps as $chirp)
                    
                <div class="p-6 flex space-x-2">
                    <svg class="h-6 w-6 text-gray-600 dark:text-gray-400 scale-x-100" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.068.157 2.148.279 3.238.364.466.037.893.281 1.153.671L12 21l2.652-3.978c.26-.39.687-.634 1.153-.67 1.09-.086 2.17-.208 3.238-.365 1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"></path>
                    </svg>
                
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-gray-800 dark:text-gray-200">
                                    {{$chirp->user->name}}
                                </span>
                                <small class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ $chirp->created_at->format('j M Y, g:i a') }}</small>
                                {{--@if ($chirp->created_at != $chirp->updated_at)--}}
                                @unless ($chirp->created_at->eq($chirp->updated_at))
                                    <small title="{{ $chirp->updated_at->format('j M Y, g:i a') }}" class="text-sm text-gray-600 dark:text-gray-400"> | {{__('Edited')}}</small>
                                @endunless
                            </div>
                        </div>
                        <p class="mt-4 text-lg text-gray-900 dark:text-gray-100">{!! nl2br($chirp->message)!!}</p>
                    </div>

                    @can('update', $chirp)
                        <!--a href="{{route('chirps.edit', $chirp)}}"> {{__('Edit Chirp')}} </a-->
                        <x-dropdown> <!-- opciones para editar y eliminar -->
                            <x-slot name="trigger"> 
                                <svg class="w-7 h-7 text-gray-500 dark:text-gray-600" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z"></path>
                                </svg>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('chirps.edit', $chirp)">
                                    {{__('Edit Chirp')}} 
                                </x-dropdown-link>
                                <form method="POST" action="{{ route('chirps.destroy', $chirp) }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                    @csrf @method('DELETE')
                                    <x-dropdown-link :href="route('chirps.destroy', $chirp)">
                                        {{__('Delete Chirp')}} 
                                    </x-dropdown-link>
                                </form>
                                
                            </x-slot>
                        </x-dropdown>    
                    @endcan
                    
                </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>
