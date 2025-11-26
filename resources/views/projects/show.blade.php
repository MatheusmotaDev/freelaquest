<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight flex items-center gap-2">
                    {{ $project->title }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Cliente: {{ $project->client->name }}</p>
            </div>
            
            <div class="flex items-center gap-3">
                <!-- SELETOR DE STATUS -->
                <form action="{{ route('projects.update-status', $project->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <select name="status" onchange="this.form.submit()" 
                            class="text-sm font-bold rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 focus:ring-arcane focus:border-arcane cursor-pointer
                            {{ $project->status == 'completed' ? 'text-green-600' : ($project->status == 'cancelled' ? 'text-red-600' : 'text-arcane') }}">
                        <option value="pending" {{ $project->status == 'pending' ? 'selected' : '' }}>🟡 Pendente</option>
                        <option value="in_progress" {{ $project->status == 'in_progress' ? 'selected' : '' }}>🔵 Em Andamento</option>
                        <option value="completed" {{ $project->status == 'completed' ? 'selected' : '' }}>🟢 Concluído</option>
                        <option value="cancelled" {{ $project->status == 'cancelled' ? 'selected' : '' }}>🔴 Cancelado</option>
                    </select>
                </form>

                <!-- BOTÃO DE RECIBO (Só aparece se concluído) -->
                @if($project->status === 'completed')
                    <a href="{{ route('projects.invoice', $project->id) }}" target="_blank" class="flex items-center gap-1 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 px-3 py-2 rounded-lg text-xs font-bold uppercase tracking-wider hover:bg-gray-700 dark:hover:bg-white transition shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        Nota / Recibo
                    </a>
                @endif

                <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 underline">
                    Voltar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- 1. RESUMO E PRAZOS -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Descrição e Tags -->
                    <div class="md:col-span-2">
                        <h3 class="text-xs font-bold text-gray-400 uppercase mb-2 tracking-wider">Sobre o Projeto</h3>
                        <p class="text-gray-700 dark:text-gray-300 text-sm whitespace-pre-line leading-relaxed">
                            {{ $project->description ?? 'Sem descrição definida.' }}
                        </p>
                        
                        <!-- Tags (Skill Tree) -->
                        @if($project->tags->count() > 0)
                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach($project->tags as $tag)
                                    <span class="px-2 py-1 text-xs rounded bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                                        #{{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Painel de Prazo (LÓGICA CORRIGIDA) -->
                    <div class="bg-gray-50 dark:bg-gray-700/30 rounded-lg p-4 border border-gray-100 dark:border-gray-700 flex flex-col justify-center">
                        <h3 class="text-xs font-bold text-gray-400 uppercase mb-3 tracking-wider text-center">Cronograma</h3>
                        
                        <div class="flex justify-between items-center mb-2 px-2">
                            <span class="text-sm text-gray-500">Entrega:</span>
                            <span class="font-bold text-gray-800 dark:text-white">{{ $project->deadline->format('d/m/Y') }}</span>
                        </div>

                        <!-- CORREÇÃO AQUI: Usamos startOfDay() para comparar dias cheios -->
                        @php
                            $now = now()->startOfDay();
                            $deadline = $project->deadline->startOfDay();
                            $daysLeft = (int) $now->diffInDays($deadline, false);
                            
                            $timerColor = 'text-green-500';
                            $timerText = $daysLeft . ' DIAS RESTANTES';

                            if ($daysLeft == 0) {
                                $timerColor = 'text-orange-500';
                                $timerText = 'É HOJE!';
                            } elseif ($daysLeft == 1) {
                                $timerColor = 'text-yellow-500';
                                $timerText = 'É AMANHÃ!';
                            } elseif ($daysLeft < 0) {
                                $timerColor = 'text-red-500';
                                $timerText = abs($daysLeft) . ' DIAS DE ATRASO';
                            } elseif ($daysLeft < 7) {
                                $timerColor = 'text-yellow-500';
                            }
                        @endphp

                        <div class="text-center mt-2">
                            <span class="text-4xl font-black {{ $timerColor }}">
                                {{ abs($daysLeft) }}
                            </span>
                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest mt-1">
                                {{ $daysLeft == 0 || $daysLeft == 1 ? '' : ($daysLeft < 0 ? 'DIAS DE ATRASO' : 'DIAS RESTANTES') }}
                            </p>
                            
                            <!-- Mensagem Extra para Hoje/Amanhã -->
                            @if($daysLeft == 0)
                                <p class="text-sm font-bold text-orange-500 animate-pulse">É HOJE! 🚀</p>
                            @elseif($daysLeft == 1)
                                <p class="text-sm font-bold text-yellow-500">É AMANHÃ! ⏰</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. SAÚDE FINANCEIRA -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @php
                    $totalRevenue = $project->invoices->where('status', 'paid')->sum('amount');
                    $totalExpenses = $project->expenses->sum('amount');
                    $profit = $totalRevenue - $totalExpenses;
                @endphp

                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border-l-4 border-blue-500 shadow-sm">
                    <p class="text-xs font-bold text-gray-400 uppercase">Receita Realizada</p>
                    <p class="text-2xl font-bold text-blue-600 dark:text-blue-400 mt-1">R$ {{ number_format($totalRevenue, 2, ',', '.') }}</p>
                    <p class="text-xs text-gray-400 mt-1">De R$ {{ number_format($project->total_amount, 2, ',', '.') }} previstos</p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border-l-4 border-red-500 shadow-sm">
                    <p class="text-xs font-bold text-gray-400 uppercase">Custos & Despesas</p>
                    <p class="text-2xl font-bold text-red-600 dark:text-red-400 mt-1">R$ {{ number_format($totalExpenses, 2, ',', '.') }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $project->expenses->count() }} lançamentos</p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border-l-4 border-emerald-500 shadow-sm">
                    <p class="text-xs font-bold text-gray-400 uppercase">Lucro Líquido</p>
                    <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-1">R$ {{ number_format($profit, 2, ',', '.') }}</p>
                    <p class="text-xs text-gray-400 mt-1">Dinheiro limpo no bolso</p>
                </div>
            </div>

            <!-- 3. LISTAS DE FATURAS E DESPESAS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <!-- Faturas -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-700/30">
                        <h3 class="font-bold text-gray-800 dark:text-white flex items-center gap-2">
                            📄 Faturas (Entradas)
                        </h3>
                        <a href="{{ route('projects.invoices.create', $project->id) }}" class="text-xs bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 hover:bg-gray-50 dark:hover:bg-gray-500 px-3 py-1 rounded font-bold transition">
                            + Nova
                        </a>
                    </div>
                    <div class="p-0">
                        @if($project->invoices->count() > 0)
                            @foreach($project->invoices as $invoice)
                                <div class="flex justify-between items-center p-4 border-b border-gray-100 dark:border-gray-700 last:border-0">
                                    <div>
                                        <p class="font-bold text-sm text-gray-800 dark:text-white">{{ $invoice->title }}</p>
                                        <p class="text-xs text-gray-500">Vence: {{ $invoice->due_date->format('d/m/Y') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-sm text-gray-800 dark:text-white">R$ {{ number_format($invoice->amount, 2, ',', '.') }}</p>
                                        @if($invoice->status === 'paid')
                                            <span class="text-[10px] uppercase font-bold text-green-600 bg-green-100 dark:bg-green-900/30 px-2 py-0.5 rounded">Pago</span>
                                        @else
                                            <form method="POST" action="{{ route('invoices.pay', $invoice->id) }}">
                                                @csrf
                                                <button type="submit" class="text-[10px] uppercase font-bold text-yellow-600 bg-yellow-100 hover:bg-yellow-200 px-2 py-0.5 rounded cursor-pointer border border-yellow-200" title="Clique para receber">
                                                    Receber
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-center text-gray-400 text-sm py-6">Nenhuma fatura criada.</p>
                        @endif
                    </div>
                </div>

                <!-- Despesas -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-700/30">
                        <h3 class="font-bold text-gray-800 dark:text-white flex items-center gap-2">
                            💸 Despesas (Saídas)
                        </h3>
                        <a href="{{ route('expenses.create') }}" class="text-xs bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 hover:bg-gray-50 dark:hover:bg-gray-500 px-3 py-1 rounded font-bold transition">
                            + Nova
                        </a>
                    </div>
                    <div class="p-0">
                        @if($project->expenses->count() > 0)
                            @foreach($project->expenses as $expense)
                                <div class="flex justify-between items-center p-4 border-b border-gray-100 dark:border-gray-700 last:border-0">
                                    <div>
                                        <p class="font-bold text-sm text-gray-800 dark:text-white">{{ $expense->description }}</p>
                                        <p class="text-xs text-gray-500">{{ $expense->incurred_date->format('d/m/Y') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-sm text-red-500">- R$ {{ number_format($expense->amount, 2, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-center text-gray-400 text-sm py-6">Nenhuma despesa lançada.</p>
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>