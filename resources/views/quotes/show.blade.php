<x-app-layout>
    <!-- Estilos Específicos para Impressão e Visual A4 -->
    <style>
        @media print {
            @page {
                margin: 0;
                size: auto; /* ou A4 */
            }
            body {
                background: white !important;
                color: black !important;
                margin: 0 !important;
            }
            /* Esconde tudo */
            body * {
                visibility: hidden;
            }
            /* Mostra e posiciona o documento */
            #printable-area, #printable-area * {
                visibility: visible;
            }
            #printable-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 0; /* Remove padding extra na impressão para não encolher */
                border: none;
                box-shadow: none;
                max-width: none !important; /* Garante largura total */
            }
            /* Esconde elementos de UI */
            .no-print {
                display: none !important;
            }
        }
    </style>

    <x-slot name="header">
        <div class="flex justify-between items-center no-print">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
                Detalhes do Orçamento
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('quotes.index') }}" class="px-4 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 underline">
                    Voltar
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Adicionamos x-data aqui para controlar o Modal -->
    <div class="py-12" x-data="{ showRejectModal: false }">
        <!-- Mudei de max-w-4xl para max-w-5xl para ficar mais largo na tela -->
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <!-- BARRA DE AÇÕES (Botões) -->
            <div class="flex flex-wrap justify-end gap-4 mb-6 no-print">
                
                <!-- Botão Imprimir -->
                <button onclick="window.print()" class="flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                    Imprimir PDF
                </button>

                <!-- LÓGICA DE BOTÕES BASEADA NO STATUS -->
                @if($quote->status === 'draft' || $quote->status === 'sent')
                    
                    <!-- Botão Recusar (Abre o Modal) -->
                    <button @click="showRejectModal = true" class="flex items-center gap-2 bg-red-100 text-red-700 border border-red-200 px-4 py-2 rounded-lg hover:bg-red-200 transition font-bold">
                        ❌ Cliente Recusou
                    </button>

                    <!-- Botão Aprovar (Leva para criar projeto) -->
                    <a href="{{ route('projects.create', ['quote_id' => $quote->id]) }}" class="flex items-center gap-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-2 rounded-lg shadow-lg hover:from-green-600 hover:to-emerald-700 transition transform hover:-translate-y-1 font-bold">
                        ✅ Aprovar & Criar Projeto
                    </a>

                @elseif($quote->status === 'accepted')
                    <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg border border-green-200 font-bold flex items-center gap-2">
                        ✅ Aprovado (Projeto Criado)
                    </div>

                @elseif($quote->status === 'rejected')
                    <div class="flex items-center gap-4">
                        <div class="bg-red-100 text-red-800 px-4 py-2 rounded-lg border border-red-200 font-bold flex items-center gap-2">
                            ⛔ Recusado pelo Cliente
                        </div>
                        <!-- Botão para tentar de novo -->
                        <a href="{{ route('quotes.create') }}" class="flex items-center gap-2 bg-arcane text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 transition">
                            📝 Criar Nova Proposta
                        </a>
                    </div>
                @endif
            </div>

            <!-- DOCUMENTO A4 (Área Imprimível) -->
            <!-- Aumentei o padding interno (p-16) para dar mais ar de "Papel" -->
            <div id="printable-area" class="bg-white text-gray-900 shadow-2xl rounded-sm overflow-hidden relative print:shadow-none print:w-full">
                
                <!-- Faixa Decorativa -->
                <div class="h-4 w-full {{ $quote->status == 'rejected' ? 'bg-red-500' : 'bg-gradient-to-r from-arcane to-mystic' }}"></div>

                <div class="p-12 md:p-16"> 
                    
                    <!-- Cabeçalho do Documento -->
                    <div class="flex justify-between items-start mb-12">
                        <div>
                            <div class="flex items-center gap-4 mb-4">
                                <!-- Placeholder de Logo (Círculo colorido) -->
                                <div class="w-12 h-12 rounded-full bg-gray-900 flex items-center justify-center text-white font-bold text-xl">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div> 
                                <div>
                                    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">{{ Auth::user()->name }}</h1>
                                    <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                                    <p class="text-sm text-gray-500">Profissional de Tecnologia</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <h2 class="text-4xl font-light text-gray-300 uppercase tracking-widest mb-2">Orçamento</h2>
                            <p class="font-bold text-gray-700 text-lg">#{{ str_pad($quote->id, 6, '0', STR_PAD_LEFT) }}</p>
                            <p class="text-sm text-gray-500">Data: {{ $quote->created_at->format('d/m/Y') }}</p>
                            @if($quote->valid_until)
                                <p class="text-sm text-red-500 font-medium mt-1">Válido até: {{ $quote->valid_until->format('d/m/Y') }}</p>
                            @endif
                        </div>
                    </div>

                    <hr class="border-gray-200 mb-12">

                    <!-- Dados do Cliente -->
                    <div class="mb-12">
                        <div class="flex justify-between items-end">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Preparado para:</p>
                                <h3 class="text-2xl font-bold text-indigo-700 mb-1">{{ $quote->client->name }}</h3>
                                @if($quote->client->company_name)
                                    <p class="text-gray-700 font-medium text-lg">{{ $quote->client->company_name }}</p>
                                @endif
                                <div class="text-gray-500 text-sm mt-2 space-y-1">
                                    <p>📧 {{ $quote->client->email }}</p>
                                    <p>📱 {{ $quote->client->phone }}</p>
                                </div>
                            </div>
                            
                            <!-- Badge de Status no Papel -->
                            <div class="text-right">
                                @php
                                    $statusLabel = match($quote->status) {
                                        'accepted' => 'APROVADO',
                                        'rejected' => 'RECUSADO',
                                        default => 'PROPOSTA'
                                    };
                                    $statusClass = match($quote->status) {
                                        'accepted' => 'border-green-600 text-green-600',
                                        'rejected' => 'border-red-600 text-red-600',
                                        default => 'text-gray-400 border-gray-200'
                                    };
                                @endphp
                                <span class="border-2 px-6 py-2 rounded uppercase font-bold text-sm tracking-widest {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Título do Projeto -->
                    <div class="mb-10 bg-gray-50 p-6 rounded border-l-4 border-arcane">
                        <p class="text-xs font-bold text-gray-400 uppercase mb-2">Projeto</p>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $quote->title }}</h2>
                    </div>

                    <!-- Descrição / Escopo -->
                    <div class="mb-16">
                        <h4 class="text-sm font-bold text-gray-800 uppercase border-b-2 border-gray-100 pb-3 mb-6">Escopo dos Serviços</h4>
                        <div class="prose text-gray-700 text-base leading-relaxed whitespace-pre-line">
                            {{ $quote->description ?? 'Descrição detalhada dos serviços não fornecida.' }}
                        </div>
                    </div>

                    <!-- Tabela de Valores -->
                    <div class="mb-16">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b-2 border-gray-800">
                                    <th class="py-3 text-sm font-bold text-gray-800 uppercase w-3/4">Descrição</th>
                                    <th class="py-3 text-sm font-bold text-gray-800 uppercase text-right w-1/4">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-gray-200">
                                    <td class="py-5 text-gray-600 font-medium">Execução do Projeto: {{ $quote->title }}</td>
                                    <td class="py-5 text-gray-800 font-bold text-right text-lg">R$ {{ number_format($quote->amount, 2, ',', '.') }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="pt-8 text-right text-gray-500 font-medium uppercase tracking-wide">Total Geral</td>
                                    <td class="pt-8 text-right text-3xl font-extrabold text-arcane">
                                        R$ {{ number_format($quote->amount, 2, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Rodapé -->
                    <div class="mt-24 pt-8 border-t border-gray-200 text-center">
                        <p class="text-gray-400 text-xs mb-12 max-w-xl mx-auto">
                            Este documento é uma proposta comercial válida por 15 dias. O pagamento deve ser realizado conforme os termos combinados.
                        </p>
                        
                        @if($quote->status !== 'rejected')
                            <div class="flex justify-around gap-8">
                                <div class="text-center flex-1">
                                    <div class="border-b border-gray-400 w-full max-w-[200px] mx-auto mb-3"></div>
                                    <p class="text-xs font-bold text-gray-500 uppercase">Assinatura do Cliente</p>
                                </div>
                                <div class="text-center flex-1">
                                    <div class="border-b border-gray-400 w-full max-w-[200px] mx-auto mb-3"></div>
                                    <p class="text-xs font-bold text-gray-500 uppercase">Assinatura do Freelancer</p>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
            
            <p class="text-center text-gray-400 text-xs mt-6 no-print">
                FreelaQuest System • Gerado em {{ now()->format('d/m/Y H:i') }}
            </p>

        </div>

        <!-- MODAL PERSONALIZADO DE REJEIÇÃO (Alpine.js) -->
        <div x-show="showRejectModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-75 no-print" style="display: none;">
            
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 max-w-md w-full transform transition-all scale-100 border border-gray-700">
                <div class="text-center">
                    <!-- Ícone de Alerta -->
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30 mb-4">
                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    
                    <h3 class="text-lg leading-6 font-bold text-gray-900 dark:text-white mb-2">
                        Confirmar Rejeição?
                    </h3>
                    
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                        Você tem certeza que deseja marcar este orçamento como <strong>RECUSADO</strong>? 
                        Isso indicará que o cliente não aceitou a proposta.
                    </p>

                    <div class="flex justify-center gap-3">
                        <!-- Botão Cancelar (Fecha Modal) -->
                        <button @click="showRejectModal = false" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-lg transition">
                            Não, cancelar
                        </button>

                        <!-- Botão Confirmar (Submete o Form) -->
                        <form method="POST" action="{{ route('quotes.reject', $quote->id) }}">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-lg shadow transition">
                                Sim, recusar orçamento
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>