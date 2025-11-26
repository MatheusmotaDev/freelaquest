<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Meus Projetos
            </h2>
            <a href="{{ route('projects.create') }}" class="bg-arcane hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg text-sm shadow transition transform hover:-translate-y-1">
                + Novo Projeto
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    @if($projects->count() > 0)
                        <div class="grid grid-cols-1 gap-4">
                            @foreach($projects as $project)
                                <a href="{{ route('projects.show', $project->id) }}" class="block group">
                                    <div class="flex flex-col md:flex-row md:items-center justify-between p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/30 hover:border-arcane dark:hover:border-arcane transition relative">
                                        
                                        <!-- Info Principal -->
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-1">
                                                <h3 class="font-bold text-lg text-gray-800 dark:text-white group-hover:text-arcane transition-colors">
                                                    {{ $project->title }}
                                                </h3>
                                                <!-- Badge de Status -->
                                                <span class="px-2 py-0.5 text-[10px] uppercase font-bold rounded-full {{ $project->status_color }}">
                                                    {{ $project->status_label }}
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-500 flex items-center gap-2">
                                                <span>👤 {{ $project->client->name }}</span>
                                                <span class="w-1 h-1 bg-gray-400 rounded-full"></span>
                                                <span>📅 Entrega: {{ $project->deadline->format('d/m/Y') }}</span>
                                            </p>
                                        </div>

                                        <!-- Financeiro -->
                                        <div class="mt-4 md:mt-0 text-right">
                                            <p class="text-sm text-gray-400 uppercase font-bold text-[10px]">Valor Total</p>
                                            <p class="text-xl font-bold text-gray-800 dark:text-white">
                                                R$ {{ number_format($project->total_amount, 2, ',', '.') }}
                                            </p>
                                        </div>

                                        <!-- Seta Indicativa -->
                                        <div class="hidden md:block ml-6 text-gray-400 group-hover:text-arcane group-hover:translate-x-1 transition">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <!-- Paginação -->
                        <div class="mt-6">
                            {{ $projects->links() }}
                        </div>
                    @else
                        <div class="text-center py-12 text-gray-400">
                            <p class="mb-2">Nenhum projeto encontrado.</p>
                            <p class="text-sm">Que tal criar o primeiro agora?</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>