<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Nova Fatura: <span class="text-arcane">{{ $project->title }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <form method="POST" action="{{ route('projects.invoices.store', $project->id) }}" class="space-y-6">
                        @csrf

                        <!-- 1. Título -->
                        <div>
                            <x-input-label for="title" :value="__('Título da Cobrança')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" required autofocus placeholder="Ex: Entrada 50%, Parcela Final, Adicional..." />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- 2. Valor -->
                            <div>
                                <x-input-label for="amount" :value="__('Valor (R$)')" />
                                <x-text-input id="amount" class="block mt-1 w-full" type="number" step="0.01" name="amount" required placeholder="0.00" />
                            </div>

                            <!-- 3. Vencimento -->
                            <div>
                                <x-input-label for="due_date" :value="__('Data de Vencimento')" />
                                <x-text-input id="due_date" class="block mt-1 w-full" type="date" name="due_date" required />
                            </div>
                        </div>

                        <!-- Botões -->
                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <a href="{{ route('projects.show', $project->id) }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 underline">
                                Cancelar
                            </a>
                            
                            <button type="submit" class="bg-victory text-white font-bold py-2 px-6 rounded-lg hover:bg-green-600 transition shadow-lg shadow-green-500/30">
                                Gerar Fatura
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>