<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Painel de Controle') }}
            </h2>
            
            <!-- GAMIFICAÇÃO: Barra de XP Clicável -->
            <a href="{{ route('leaderboard.index') }}" class="group transition transform hover:scale-105 cursor-pointer" title="Ver Ranking e Evolução">
                <div class="flex items-center gap-4 bg-white dark:bg-gray-800 px-4 py-2 rounded-full shadow-sm border border-gray-200 dark:border-gray-700 relative overflow-hidden">
                    <!-- Barra de Fundo (Progresso) -->
                    <div class="absolute bottom-0 left-0 h-1 bg-mystic/30 w-full">
                        <div class="h-full bg-mystic transition-all duration-1000" style="width: {{ Auth::user()->xp_progress }}%"></div>
                    </div>

                    <div class="text-right z-10">
                        <p class="text-xs text-gray-500 uppercase font-bold tracking-wider group-hover:text-arcane transition-colors">
                            Nível {{ Auth::user()->current_level }}
                        </p>
                        <p class="text-sm font-bold text-white">
                            {{ Auth::user()->current_xp }} / {{ Auth::user()->current_level * 1000 }} XP
                        </p>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-mystic flex items-center justify-center text-white font-bold shadow-lg shadow-mystic/50 z-10 group-hover:bg-arcane transition-colors">
                        {{ Auth::user()->current_level }}
                    </div>
                </div>
            </a>
        </div>
    </x-slot>

    <!-- x-data controla o Modal de Meta -->
    <div class="py-12" x-data="{ showGoalModal: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- ALERTA DE SUCESSO -->
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" class="bg-green-100 border-l-4 border-victory text-green-700 dark:bg-green-900/30 dark:text-green-200 p-4 rounded shadow-sm flex justify-between items-center animate-bounce-once" role="alert">
                    <div class="flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>
                            <strong class="font-bold">Sucesso!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    </div>
                    <button @click="show = false" class="text-green-700 dark:text-green-200 font-bold hover:text-green-900">&times;</button>
                </div>
            @endif

            <!-- CARDS FINANCEIROS -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1: A Receber -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-arcane p-6 relative group hover:scale-[1.02] transition duration-300">
                    <div class="text-gray-500 text-sm font-medium uppercase tracking-wide">A Receber</div>
                    <div class="text-3xl font-extrabold text-gray-800 dark:text-white mt-2">
                        R$ {{ number_format($totalReceivables, 2, ',', '.') }}
                    </div>
                    <div class="text-xs text-gray-400 mt-2 font-medium">Faturas pendentes</div>
                </div>

                <!-- Card 2: Lucro Real -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-emerald-500 p-6 relative hover:scale-[1.02] transition duration-300">
                    <div class="text-gray-500 text-sm font-medium uppercase tracking-wide">Lucro Real (Pago)</div>
                    <div class="text-3xl font-extrabold text-emerald-600 dark:text-emerald-400 mt-2">
                        R$ {{ number_format($realProfit, 2, ',', '.') }}
                    </div>
                    <div class="text-xs text-emerald-600/60 dark:text-emerald-400/60 mt-2 font-medium">Dinheiro no bolso</div>
                </div>

                <!-- Card 3: Meta (Dinâmica e Editável) -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 relative group border-l-4 border-prestige">
                    
                    <!-- Botão Editar (Lápis) -->
                    <button @click="showGoalModal = true" class="absolute top-4 right-4 text-gray-400 hover:text-arcane transition opacity-0 group-hover:opacity-100" title="Gerenciar Meta">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                    </button>

                    @php
                        $activeGoal = Auth::user()->activeGoal;
                        $goalTarget = $activeGoal ? $activeGoal->amount : 1;
                        $progress = 0;
                        if ($activeGoal) {
                            $progress = ($realProfit / $goalTarget) * 100;
                            if($progress > 100) $progress = 100;
                            if($progress < 0) $progress = 0;
                        }
                    @endphp

                    @if($activeGoal)
                        <div class="flex justify-between items-end mb-2">
                            <div>
                                <div class="text-gray-500 text-sm font-medium uppercase tracking-wide flex items-center gap-2">
                                    Meta: {{ $activeGoal->title }}
                                </div>
                                <div class="text-2xl font-bold text-gray-800 dark:text-white mt-1">
                                    {{ number_format($progress, 0) }}%
                                </div>
                            </div>
                            <div class="text-right text-xs text-gray-400 font-mono">
                                R$ {{ number_format($realProfit, 2, ',', '.') }} <br> 
                                <span class="text-gray-600 dark:text-gray-500">/ {{ number_format($goalTarget, 2, ',', '.') }}</span>
                            </div>
                        </div>
                        
                        <!-- Barra de Progresso -->
                        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mt-3 mb-4">
                            <div class="bg-gradient-to-r from-prestige to-yellow-500 h-2.5 rounded-full shadow-[0_0_15px_rgba(242,201,76,0.5)] transition-all duration-1000 ease-out" 
                                 style="width: {{ $progress }}%"></div>
                        </div>

                        <!-- Botões de Ação da Meta -->
                        <div class="flex gap-2 mt-2">
                            @if($progress >= 100)
                                <form method="POST" action="{{ route('goals.complete', $activeGoal->id) }}">
                                    @csrf
                                    <button type="submit" class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded border border-green-200 font-bold hover:bg-green-200 transition animate-pulse">
                                        🎉 Concluir & Arquivar
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('goals.index') }}" class="text-xs text-gray-500 hover:text-arcane underline flex items-center gap-1">
                                Ver Histórico
                            </a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-gray-400 text-sm mb-2">Sem meta ativa.</p>
                            <button @click="showGoalModal = true" class="text-xs bg-arcane text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                                + Definir Objetivo
                            </button>
                            <div class="mt-2">
                                <a href="{{ route('goals.index') }}" class="text-xs text-gray-500 hover:text-arcane underline">
                                    Ver Histórico
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- ÁREA DE AÇÕES E PROJETOS -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Coluna da Esquerda: Botões e Widget -->
                <div class="md:col-span-1 space-y-3">
                    
                    <!-- 1. NOVO ORÇAMENTO (Destaque Principal) -->
                    <a href="{{ route('quotes.create') }}" class="group w-full bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-orange-500/30 transition transform hover:-translate-y-1 flex items-center justify-center gap-3 cursor-pointer relative overflow-hidden">
                        <span class="bg-white/20 rounded-full p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </span>
                        <div class="text-left">
                            <span class="block text-xs font-normal opacity-90">Começar aqui</span>
                            <span class="block text-sm font-bold">Novo Orçamento</span>
                        </div>
                    </a>

                    <!-- 2. PROJETO DIRETO (Secundário) -->
                    <a href="{{ route('projects.create') }}" class="w-full bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-semibold py-3 px-4 rounded-xl transition flex items-center justify-center gap-2 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-arcane" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        <span>Projeto Direto</span>
                    </a>
                    
                    <!-- 3. NOVA DESPESA -->
                    <a href="{{ route('expenses.create') }}" class="w-full bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-semibold py-3 px-4 rounded-xl transition flex items-center justify-center gap-2 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>Lançar Despesa</span>
                    </a>

                    <!-- WIDGET: A RECEBER HOJE (Pagamento Rápido) -->
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-100 dark:border-gray-700/50 shadow-sm mt-4">
                        <h4 class="font-bold text-gray-700 dark:text-gray-300 mb-3 text-sm uppercase tracking-wider">A receber</h4>
                        
                        @php
                            $pendingInvoices = \App\Models\Invoice::with('project.client') 
                                ->whereHas('project', function($q){ $q->where('user_id', Auth::id()); })
                                ->where('status', 'pending')
                                ->orderBy('due_date', 'asc')
                                ->take(3)
                                ->get();
                        @endphp

                        @if($pendingInvoices->count() > 0)
                            <div class="space-y-3">
                                @foreach($pendingInvoices as $invoice)
                                    <div class="flex justify-between items-center p-2 bg-gray-50 dark:bg-gray-700/30 rounded border border-gray-100 dark:border-gray-700">
                                        <div class="overflow-hidden pr-2">
                                            <p class="text-[10px] uppercase font-bold text-arcane mb-0.5 truncate" title="{{ $invoice->project->client->name }}">
                                                {{ $invoice->project->client->name }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate w-20" title="{{ $invoice->title }}">
                                                {{ $invoice->title }}
                                            </p>
                                            <p class="font-bold text-gray-800 dark:text-white text-xs">R$ {{ number_format($invoice->amount, 0, ',', '.') }}</p>
                                        </div>
                                        
                                        <!-- Botão Receber com Gamificação -->
                                        <form method="POST" action="{{ route('invoices.pay', $invoice->id) }}">
                                            @csrf
                                            <button type="submit" class="text-xs bg-victory/10 text-victory hover:bg-victory hover:text-white px-2 py-1 rounded transition border border-victory/20 font-bold tracking-wide">
                                                RECEBER
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-xs text-gray-400 text-center py-2">Nada pendente!</p>
                        @endif
                    </div>
                </div>

                <!-- Lista de Projetos Recentes -->
                <div class="md:col-span-3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-700/50">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-arcane" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                            Projetos Recentes
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        @if($activeProjects->count() > 0)
                            <div class="space-y-3">
                                @foreach($activeProjects as $project)
                                    <!-- Card Linkado -->
                                    <a href="{{ route('projects.show', $project->id) }}" class="block">
                                        <div class="group flex flex-col sm:flex-row sm:items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/30 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-arcane dark:hover:border-arcane/50 hover:bg-white dark:hover:bg-gray-700 transition duration-200 cursor-pointer">
                                            <div class="flex flex-col">
                                                <h4 class="font-bold text-gray-800 dark:text-white text-base group-hover:text-arcane transition-colors">{{ $project->title }}</h4>
                                                <p class="text-sm text-gray-500 flex items-center gap-1">
                                                    <span class="w-2 h-2 rounded-full bg-gray-300"></span>
                                                    {{ $project->client->name }}
                                                </p>
                                            </div>
                                            <div class="mt-3 sm:mt-0 text-right flex items-center gap-4 justify-between sm:justify-end">
                                                <p class="font-bold text-gray-800 dark:text-gray-200 text-lg">R$ {{ number_format($project->total_amount, 2, ',', '.') }}</p>
                                                
                                                <!-- Status Badge -->
                                                <span class="text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider {{ $project->status_color }}">
                                                    {{ $project->status_label }}
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12 text-gray-400 border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800/50">
                                <p class="font-medium">Nenhum projeto ativo.</p>
                                <p class="text-sm mt-1">Comece criando um orçamento!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL DE EDITAR META (Nova Rota) -->
        <div x-show="showGoalModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-75" style="display: none;">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 max-w-md w-full transform transition-all scale-100">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Gerenciar Meta Atual</h3>
                
                <form method="POST" action="{{ route('goals.store') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome do Objetivo</label>
                        <input type="text" name="title" value="{{ Auth::user()->activeGoal->title ?? '' }}" 
                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-arcane focus:ring-arcane"
                               placeholder="Ex: Macbook Air..." required>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Valor Alvo (R$)</label>
                        <input type="number" step="0.01" name="amount" value="{{ Auth::user()->activeGoal->amount ?? '' }}" 
                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-arcane focus:ring-arcane" required>
                    </div>
                    
                    @if(Auth::user()->activeGoal)
                        <div class="mb-4 text-right">
                            <button type="submit" formaction="{{ route('goals.archive', Auth::user()->activeGoal->id) }}" class="text-xs text-red-500 hover:text-red-700 underline">
                                Desistir e arquivar
                            </button>
                        </div>
                    @endif

                    <div class="flex justify-end gap-3 border-t border-gray-200 dark:border-gray-700 pt-4">
                        <button type="button" @click="showGoalModal = false" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg transition">Fechar</button>
                        <button type="submit" class="px-4 py-2 bg-arcane hover:bg-blue-600 text-white font-bold rounded-lg shadow transition">Salvar Meta</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>