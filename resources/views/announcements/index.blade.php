<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Mural de Comunicados
            </h2>
            
            <!-- Botão de Novo (Só Admin) -->
            @if(Auth::user()->is_admin)
                <a href="{{ route('announcements.create') }}" class="bg-arcane hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg text-sm shadow transition">
                    + Novo Comunicado
                </a>
            @endif
        </div>
    </x-slot>

    <!-- CONTAINER PRINCIPAL COM O X-DATA DO MODAL -->
    <div class="py-12" x-data="{ showDeleteModal: false, deleteUrl: '' }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Mensagem de Sucesso -->
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm flex justify-between">
                    <span>{{ session('success') }}</span>
                    <button @click="show = false" class="text-green-700 font-bold">&times;</button>
                </div>
            @endif

            <div class="space-y-8">
                @forelse($announcements as $post)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700 hover:border-arcane transition relative" x-data="{ showComments: false }">
                        
                        <!-- Conteúdo do Post -->
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-3">
                                    <span class="text-3xl">{{ $post->icon }}</span>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $post->title }}</h3>
                                        <span class="text-xs text-gray-500">
                                            Por {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <!-- Badge de Tipo -->
                                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $post->color }}">
                                        {{ $post->type }}
                                    </span>

                                    <!-- BOTÃO DE EXCLUIR (Só Admin) -->
                                    <!-- Em vez de form direto, é um botão que abre o modal -->
                                    @if(Auth::user()->is_admin)
                                        <button @click="showDeleteModal = true; deleteUrl = '{{ route('announcements.destroy', $post->id) }}'" 
                                                class="text-gray-400 hover:text-red-500 transition p-2 bg-gray-100 dark:bg-gray-700 rounded-full h-8 w-8 flex items-center justify-center hover:bg-red-100 dark:hover:bg-red-900/30" 
                                                title="Apagar Comunicado">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300 text-sm whitespace-pre-line leading-relaxed mb-6">
                                {{ $post->content }}
                            </div>

                            <!-- Barra de Ações (Botão Comentários) -->
                            <div class="flex items-center gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                <button @click="showComments = !showComments" class="flex items-center gap-2 text-sm text-gray-500 hover:text-arcane transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" /></svg>
                                    <span>{{ $post->comments->count() }} Comentários</span>
                                </button>
                            </div>
                        </div>

                        <!-- Área de Comentários (Expansível) -->
                        <div x-show="showComments" style="display: none;" x-transition class="bg-gray-50 dark:bg-gray-900/50 p-6 border-t border-gray-100 dark:border-gray-700">
                            
                            <div class="space-y-4 mb-6 max-h-96 overflow-y-auto">
                                @forelse($post->comments as $comment)
                                    <div class="flex gap-3 group/comment">
                                        <div class="shrink-0 w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-xs font-bold text-gray-600 dark:text-gray-300">
                                            {{ substr($comment->user->name, 0, 1) }}
                                        </div>
                                        
                                        <div class="flex-1 bg-white dark:bg-gray-800 p-3 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm relative">
                                            <div class="flex justify-between items-center mb-1">
                                                <span class="font-bold text-xs text-gray-800 dark:text-white">{{ $comment->user->name }}</span>
                                                <span class="text-[10px] text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-sm text-gray-600 dark:text-gray-300">{{ $comment->content }}</p>
                                            
                                            <!-- Excluir Comentário -->
                                            @if($comment->user_id === Auth::id() || Auth::user()->is_admin)
                                                <form method="POST" action="{{ route('comments.destroy', $comment->id) }}" class="absolute bottom-2 right-3 opacity-0 group-hover/comment:opacity-100 transition">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-[10px] text-red-400 hover:text-red-600 hover:underline">Excluir</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-gray-400 text-sm">Seja o primeiro a comentar!</p>
                                @endforelse
                            </div>

                            <!-- Formulário Novo Comentário -->
                            <form method="POST" action="{{ route('comments.store', $post->id) }}" class="flex gap-2">
                                @csrf
                                <input type="text" name="content" required placeholder="Escreva um comentário..." 
                                       class="flex-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white text-sm focus:ring-arcane focus:border-arcane">
                                <button type="submit" class="bg-gray-900 dark:bg-gray-700 text-white p-2 rounded-lg hover:bg-arcane transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                                </button>
                            </form>

                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl">📭</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Mural Vazio</h3>
                        <p class="text-gray-500 mt-2">Nenhum comunicado oficial por enquanto.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- MODAL DE EXCLUSÃO (Alpine.js) -->
        <div x-show="showDeleteModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-75" 
             style="display: none;">
            
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 max-w-md w-full transform transition-all scale-100 border border-gray-700">
                <div class="text-center">
                    <!-- Ícone de Alerta -->
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30 mb-4">
                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                    
                    <h3 class="text-lg leading-6 font-bold text-gray-900 dark:text-white mb-2">
                        Excluir Comunicado?
                    </h3>
                    
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                        Você tem certeza que deseja apagar este aviso permanentemente? Essa ação não pode ser desfeita.
                    </p>

                    <div class="flex justify-center gap-3">
                        <!-- Botão Cancelar -->
                        <button @click="showDeleteModal = false" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-lg transition">
                            Cancelar
                        </button>

                        <!-- Botão Confirmar Exclusão -->
                        <form :action="deleteUrl" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-lg shadow transition">
                                Sim, apagar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>