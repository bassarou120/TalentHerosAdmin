<x-filament-panels::page>

    <h2 class="text-center text-xl font-bold mb-6">Messages reçus</h2>

    <div class="chat-container max-w-2xl mx-auto p-4 border border-gray-300 rounded-lg shadow-md">
        <ul class="space-y-4">
            @foreach($messages as $message)
                <li class="flex {{ $message->sender->id == auth()->user()->id ? 'justify-end' : 'justify-start' }}">
                    <!-- Display sender's profile picture -->
{{--                    @if ($message->sender->id != auth()->user()->id)--}}
{{--                        <div class="flex-shrink-0 mr-2">--}}
{{--                            <img src="{{ $message->sender->profile_picture_url ?? 'default-avatar.png' }}"--}}
{{--                                 alt="Profile" class="w-10 h-10 rounded-full">--}}
{{--                        </div>--}}
{{--                    @endif--}}

                <!-- Chat bubble -->

                    <strong class="text-sm font-semibold">
{{--                        {{ $message->sender->name }}  --}}
{{--                        <br>--}}
{{--                        A--}}
{{--                        <br>--}}
                        {{$message->sender->id == auth()->user()->id ? $message->receiver->name : $message->sender->name }} :</strong>

                    <div class="chat-bubble p-3 rounded-lg {{ $message->sender->id == auth()->user()->id ? 'bg-blue-500 text-white' : 'bg-gray-200' }}">
                        <div class="flex items-center justify-between">
{{--                            <strong class="text-sm font-semibold">{{ $message->sender->name }}</strong>--}}
{{--                            <strong class="text-sm font-semibold">{{ $message->receiver->name }}</strong>--}}
                            <span class="text-xs text-gray-500">{{ $message->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <p class="text-sm">{{ $message->message }}</p>
{{--                        <div class="mt-2">--}}
{{--                            @if (!$message->read_at)--}}
{{--                                <x-filament::button size="sm" wire:click="markAsRead({{ $message->id }})">Marquer comme lu</x-filament::button>--}}
{{--                            @endif--}}
{{--                        </div>--}}
                    </div>

                    <!-- Display sender's profile picture for sent messages -->
{{--                    @if ($message->sender->id == auth()->user()->id)--}}
{{--                        <div class="flex-shrink-0 ml-2">--}}
{{--                            <img src="{{ $message->sender->profile_picture_url ?? 'default-avatar.png' }}"--}}
{{--                                 alt="Profile" class="w-10 h-10 rounded-full">--}}
{{--                        </div>--}}
{{--                    @endif--}}
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Styling specific to this layout -->
    <style>
        .chat-container {
            width: 100%;
            /*max-height: 500px;*/
            /*overflow-y: auto;*/
        }

        .chat-bubble {
            width: 80%;
            max-width: 100%;
            word-wrap: break-word;
        }

        /* Style for received and sent messages */
        .justify-start .chat-bubble {
            background-color: #f0f0f0;
            color: #333;
        }

        .justify-end .chat-bubble {
            background-color: #02254f;
            color: #fff;
        }
    </style>

</x-filament-panels::page>


{{--<x-filament-panels::page>--}}

{{--    <h2>Messages reçus</h2>--}}
{{--    <ul>--}}
{{--        @foreach($messages as $message)--}}
{{--            <li>--}}
{{--                <strong>{{ $message->sender->name }}</strong> :--}}
{{--                {{ $message->message }}--}}
{{--                <x-filament::button wire:click="markAsRead({{ $message->id }})">Marquer comme lu</x-filament::button>--}}
{{--            </li>--}}
{{--        @endforeach--}}
{{--    </ul>--}}

{{--</x-filament-panels::page>--}}
