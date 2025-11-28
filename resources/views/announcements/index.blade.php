<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Mural de Comunicados
            </h2>
            
            
            @if(Auth::user()->is_admin)
                <a href="{{ route('announcements.create') }}" class="bg-arcane hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg text-sm shadow transition">
                    + Novo Comunicado
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="space-y-6">
                @forelse($announcements as $post)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700 hover:border-arcane transition">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-3">
                                    <span class="text-2xl">{{ $post->icon }}</span>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $post->title }}</h3>
                                        <span class="text-xs text-gray-500">Postado em {{ $post->created_at->format('d/m/Y \à\s H:i') }}</span>
                                    </div>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $post->color }}">
                                    {{ $post->type }}
                                </span>
                            </div>
                            
                            <div class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300 text-sm whitespace-pre-line">
                                {{ $post->content }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
                        <p class="text-gray-500">Nenhum comunicado oficial por enquanto.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>