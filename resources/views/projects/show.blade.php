<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight truncate">
                {{ $project->title }}
            </h2>
            <div class="flex items-center gap-3">
                <!-- Status Badge -->
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $project->status_color }}">
                    {{ $project->status_label }}
                </span>
                
                <!-- Botão Voltar -->
                <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 underline">
                    Voltar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- 1. RESUMO DO PROJETO -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Cliente -->
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold">Cliente</p>
                        <p class="text-lg font-bold text-gray-800 dark:text-white">{{ $project->client->name }}</p>
                        <p class="text-sm text-gray-400">{{ $project->client->email }}</p>
                    </div>

                    <!-- Prazos -->
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold">Prazo de Entrega</p>
                        <p class="text-lg font-bold text-gray-800 dark:text-white">
                            {{ $project->deadline ? $project->deadline->format('d/m/Y') : 'Sem data' }}
                        </p>
                        <!-- Lógica simples de dias restantes -->
                        @php
                            $daysLeft = now()->diffInDays($project->deadline, false);
                        @endphp
                        <p class="text-sm {{ $daysLeft < 0 ? 'text-red-500' : 'text-green-500' }}">
                            {{ $daysLeft < 0 ? 'Atrasado ' . abs((int)$daysLeft) . ' dias' : $daysLeft . ' dias restantes' }}
                        </p>
                    </div>

                    <!-- Financeiro Mini -->
                    <div class="text-right">
                        <p class="text-xs text-gray-500 uppercase font-bold">Valor Total</p>
                        <p class="text-2xl font-bold text-arcane">R$ {{ number_format($project->total_amount, 2, ',', '.') }}</p>
                    </div>
                </div>
                
                <!-- Descrição -->
                @if($project->description)
                    <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-700">
                        <p class="text-xs text-gray-500 uppercase font-bold mb-2">Escopo / Descrição</p>
                        <p class="text-gray-600 dark:text-gray-300 text-sm whitespace-pre-line">{{ $project->description }}</p>
                    </div>
                @endif
            </div>

            <!-- 2. ÁREA FINANCEIRA (FATURAS E DESPESAS) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- COLUNA DA ESQUERDA: FATURAS (Receitas) -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white flex items-center gap-2">
                            <span class="text-green-500">⬇</span> Faturas (Receitas)
                        </h3>
                        <!-- Botão Fake por enquanto -->
                        <a href="{{ route('projects.invoices.create', $project->id) }}" class="text-xs bg-victory/10 text-victory hover:bg-victory hover:text-white px-3 py-1 rounded transition border border-victory/20 font-bold">
                            + Criar Fatura
                        </a>
                    </div>

                    @if($project->invoices->count() > 0)
                        <div class="space-y-3">
                            @foreach($project->invoices as $invoice)
                                <div class="flex justify-between items-center p-3 rounded-lg border {{ $invoice->status === 'paid' ? 'border-green-200 bg-green-50 dark:bg-green-900/20 dark:border-green-800' : 'border-gray-100 bg-gray-50 dark:bg-gray-700/30 dark:border-gray-700' }}">
                                    <div>
                                        <p class="font-bold text-sm text-gray-800 dark:text-white">{{ $invoice->title }}</p>
                                        <p class="text-xs text-gray-500">Vence: {{ $invoice->due_date->format('d/m/Y') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-sm text-gray-800 dark:text-white">R$ {{ number_format($invoice->amount, 2, ',', '.') }}</p>
                                        
                                        @if($invoice->status === 'paid')
                                            <span class="text-[10px] uppercase font-bold text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-900/50 px-2 py-0.5 rounded">PAGO</span>
                                        @else
                                            <span class="text-[10px] uppercase font-bold text-yellow-600 dark:text-yellow-400 bg-yellow-100 dark:bg-yellow-900/50 px-2 py-0.5 rounded">PENDENTE</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-400 text-center py-4">Nenhuma fatura gerada ainda.</p>
                    @endif
                </div>

                <!-- COLUNA DA DIREITA: DESPESAS (Gastos) -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white flex items-center gap-2">
                            <span class="text-red-500">⬆</span> Despesas (Custos)
                        </h3>
                        <!-- Link para criar despesa já vinculada (futuro) -->
                        <a href="{{ route('expenses.create') }}" class="text-xs bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 px-3 py-1 rounded transition border border-gray-300 dark:border-gray-600">
                            + Lançar Gasto
                        </a>
                    </div>

                    @if($project->expenses->count() > 0)
                        <div class="space-y-3">
                            @foreach($project->expenses as $expense)
                                <div class="flex justify-between items-center p-3 rounded-lg border border-red-100 bg-red-50 dark:bg-red-900/10 dark:border-red-900/30">
                                    <div>
                                        <p class="font-bold text-sm text-gray-800 dark:text-white">{{ $expense->description }}</p>
                                        <p class="text-xs text-gray-500">{{ $expense->incurred_date->format('d/m/Y') }}</p>
                                    </div>
                                    <p class="font-bold text-sm text-red-500">- R$ {{ number_format($expense->amount, 2, ',', '.') }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-400 text-center py-4">Nenhuma despesa registrada. Lucro total!</p>
                    @endif
                </div>

            </div>

        </div>
    </div>
</x-app-layout>