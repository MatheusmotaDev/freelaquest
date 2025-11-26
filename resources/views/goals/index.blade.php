<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Histórico de Metas
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 underline hover:text-gray-700">Voltar ao Painel</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                
                @if($goals->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($goals as $goal)
                            <div class="relative p-6 rounded-xl border {{ $goal->status == 'active' ? 'border-arcane bg-blue-50 dark:bg-blue-900/20' : ($goal->status == 'completed' ? 'border-green-500 bg-green-50 dark:bg-green-900/20' : 'border-gray-200 bg-gray-50 dark:bg-gray-700/30 opacity-75') }}">
                                
                                <!-- Badge de Status -->
                                <div class="absolute top-4 right-4">
                                    @if($goal->status == 'active')
                                        <span class="text-xs font-bold text-blue-600 bg-blue-100 px-2 py-1 rounded">EM ANDAMENTO</span>
                                    @elseif($goal->status == 'completed')
                                        <span class="text-xs font-bold text-green-600 bg-green-100 px-2 py-1 rounded">CONQUISTADA 🏆</span>
                                    @else
                                        <span class="text-xs font-bold text-gray-500 bg-gray-200 px-2 py-1 rounded">ARQUIVADA</span>
                                    @endif
                                </div>

                                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-1">{{ $goal->title }}</h3>
                                <p class="text-2xl font-extrabold text-gray-900 dark:text-gray-200">R$ {{ number_format($goal->amount, 2, ',', '.') }}</p>
                                
                                <div class="mt-4 text-xs text-gray-500">
                                    <p>Criada em: {{ $goal->created_at->format('d/m/Y') }}</p>
                                    @if($goal->achieved_at)
                                        <p class="text-green-600 font-bold">Conquistada em: {{ $goal->achieved_at->format('d/m/Y') }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 text-gray-400">
                        <p>Você ainda não tem histórico de metas.</p>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>