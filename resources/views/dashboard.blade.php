<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Painel de Controle') }}
            </h2>
            <div class="flex items-center gap-4 bg-white dark:bg-gray-800 px-4 py-2 rounded-full shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="text-right">
                    <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Estagiário Nível 1</p>
                    <p class="text-sm font-bold text-mystic">0 / 1000 XP</p>
                </div>
                <div class="h-10 w-10 rounded-full bg-mystic flex items-center justify-center text-white font-bold shadow-lg shadow-mystic/50">
                    1
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-arcane p-6">
                    <div class="text-gray-500 text-sm font-medium uppercase">A Receber</div>
                    <div class="text-3xl font-bold text-gray-800 dark:text-white mt-1">R$ 0,00</div>
                    <div class="text-xs text-gray-400 mt-2">2 Faturas pendentes</div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-victory p-6">
                    <div class="text-gray-500 text-sm font-medium uppercase">Lucro Real (Mês)</div>
                    <div class="text-3xl font-bold text-victory mt-1">R$ 0,00</div>
                    <div class="text-xs text-gray-400 mt-2">Já descontando despesas</div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 relative">
                    <div class="flex justify-between items-end mb-2">
                        <div>
                            <div class="text-gray-500 text-sm font-medium uppercase">Meta: Macbook Air</div>
                            <div class="text-2xl font-bold text-gray-800 dark:text-white">0%</div>
                        </div>
                        <div class="text-right text-xs text-gray-400">
                            R$ 0,00 / R$ 7.000,00
                        </div>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                        <div class="bg-prestige h-2.5 rounded-full shadow-[0_0_10px_#F2C94C]" style="width: 5%"></div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="md:col-span-1 space-y-4">
                    <button class="w-full bg-arcane hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg shadow-arcane/30 transition transform hover:-translate-y-1 flex items-center justify-center gap-2">
                        <span>+</span> Novo Projeto
                    </button>
                    <button class="w-full bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-white font-bold py-3 px-4 rounded-lg border border-gray-200 dark:border-gray-600 transition flex items-center justify-center gap-2">
                        <span>$</span> Nova Despesa
                    </button>
                </div>

                <div class="md:col-span-3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Projetos Ativos</h3>
                    
                    <div class="text-center py-10 text-gray-400 border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-lg">
                        <p>Nenhum projeto em andamento.</p>
                        <p class="text-sm">Que tal criar o primeiro e começar a ganhar XP?</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>