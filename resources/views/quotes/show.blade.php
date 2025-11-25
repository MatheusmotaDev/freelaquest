<x-app-layout>
    <!-- Estilos Específicos para Impressão -->
    <style>
        @media print {
            body * { visibility: hidden; }
            #printable-area, #printable-area * { visibility: visible; }
            #printable-area {
                position: absolute;
                left: 0; top: 0; width: 100%;
                margin: 0; padding: 0;
                background: white; border: none; box-shadow: none;
            }
            .no-print { display: none !important; }
            body { background: white !important; color: black !important; }
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
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- BARRA DE AÇÕES -->
            <div class="flex flex-wrap justify-end gap-4 mb-6 no-print">
                
                <!-- Botão Imprimir -->
                <button onclick="window.print()" class="flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                    Imprimir PDF
                </button>

                @if($quote->status === 'draft' || $quote->status === 'sent')
                    
                    <!-- Botão Recusar (Abre o Modal) -->
                    <button @click="showRejectModal = true" class="flex items-center gap-2 bg-red-100 text-red-700 border border-red-200 px-4 py-2 rounded-lg hover:bg-red-200 transition font-bold">
                        ❌ Cliente Recusou
                    </button>

                    <!-- Botão Aprovar -->
                    <form method="POST" action="{{ route('quotes.convert', $quote->id) }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-2 rounded-lg shadow-lg hover:from-green-600 hover:to-emerald-700 transition transform hover:-translate-y-1 font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Aprovar & Criar Projeto
                        </button>
                    </form>

                @elseif($quote->status === 'accepted')
                    <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg border border-green-200 font-bold flex items-center gap-2">
                        ✅ Aprovado (Projeto Criado)
                    </div>

                @elseif($quote->status === 'rejected')
                    <div class="flex items-center gap-4">
                        <div class="bg-red-100 text-red-800 px-4 py-2 rounded-lg border border-red-200 font-bold flex items-center gap-2">
                            ⛔ Recusado pelo Cliente
                        </div>
                        <a href="{{ route('quotes.create') }}" class="flex items-center gap-2 bg-arcane text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 transition">
                            📝 Criar Nova Proposta
                        </a>
                    </div>
                @endif
            </div>

            <!-- DOCUMENTO A4 (Mantido igual) -->
            <div id="printable-area" class="bg-white text-gray-900 shadow-2xl rounded-none sm:rounded-sm overflow-hidden relative print:shadow-none">
                <div class="h-4 w-full {{ $quote->status == 'rejected' ? 'bg-red-500' : 'bg-gradient-to-r from-arcane to-mystic' }}"></div>
                <div class="p-12"> 
                    <div class="flex justify-between items-start mb-12">
                        <div>
                            <div class="flex items-center gap-3 mb-4">
                                <div class="text-4xl">🔷</div> 
                                <div>
                                    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">{{ Auth::user()->name }}</h1>
                                    <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                                    <p class="text-sm text-gray-500">Profissional de Tecnologia</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <h2 class="text-4xl font-light text-gray-300 uppercase tracking-widest mb-2">Orçamento</h2>
                            <p class="font-bold text-gray-700">#{{ str_pad($quote->id, 6, '0', STR_PAD_LEFT) }}</p>
                            <p class="text-sm text-gray-500">Data: {{ $quote->created_at->format('d/m/Y') }}</p>
                            @if($quote->valid_until)
                                <p class="text-sm text-red-500 font-medium">Válido até: {{ $quote->valid_until->format('d/m/Y') }}</p>
                            @endif
                        </div>
                    </div>
                    <hr class="border-gray-200 mb-12">
                    <div class="mb-12">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Preparado para:</p>
                        <div class="flex justify-between items-end">
                            <div>
                                <h3 class="text-xl font-bold text-arcane">{{ $quote->client->name }}</h3>
                                @if($quote->client->company_name)
                                    <p class="text-gray-600 font-medium">{{ $quote->client->company_name }}</p>
                                @endif
                                <p class="text-gray-500 text-sm mt-1">{{ $quote->client->email }}</p>
                                <p class="text-gray-500 text-sm">{{ $quote->client->phone }}</p>
                            </div>
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
                                <span class="border-2 px-4 py-1 rounded uppercase font-bold text-sm tracking-widest {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-8 bg-gray-50 p-4 rounded border-l-4 border-arcane">
                        <p class="text-xs font-bold text-gray-400 uppercase mb-1">Projeto</p>
                        <h2 class="text-xl font-bold text-gray-800">{{ $quote->title }}</h2>
                    </div>
                    <div class="mb-12">
                        <h4 class="text-sm font-bold text-gray-800 uppercase border-b border-gray-200 pb-2 mb-4">Escopo dos Serviços</h4>
                        <div class="prose text-gray-600 text-sm leading-relaxed whitespace-pre-line">
                            {{ $quote->description ?? 'Descrição detalhada dos serviços não fornecida.' }}
                        </div>
                    </div>
                    <div class="mb-12">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b-2 border-gray-800">
                                    <th class="py-3 text-sm font-bold text-gray-800 uppercase w-3/4">Descrição</th>
                                    <th class="py-3 text-sm font-bold text-gray-800 uppercase text-right w-1/4">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-gray-200">
                                    <td class="py-4 text-gray-600">Execução do Projeto: {{ $quote->title }}</td>
                                    <td class="py-4 text-gray-800 font-bold text-right">R$ {{ number_format($quote->amount, 2, ',', '.') }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="pt-6 text-right text-gray-500 font-medium">Total Geral</td>
                                    <td class="pt-6 text-right text-2xl font-extrabold text-arcane">
                                        R$ {{ number_format($quote->amount, 2, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="mt-20 pt-8 border-t border-gray-200 text-center">
                        <p class="text-gray-400 text-xs mb-8">
                            Este documento é uma proposta comercial. A validade e os termos estão sujeitos a confirmação.
                        </p>
                        @if($quote->status !== 'rejected')
                            <div class="flex justify-around mt-16">
                                <div class="text-center">
                                    <div class="border-b border-gray-400 w-48 mb-2"></div>
                                    <p class="text-xs font-bold text-gray-500 uppercase">Assinatura do Cliente</p>
                                </div>
                                <div class="text-center">
                                    <div class="border-b border-gray-400 w-48 mb-2"></div>
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

        <!-- MODAL PERSONALIZADO DE REJEIÇÃO -->
        <div x-show="showRejectModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-75 no-print" style="display: none;">
            
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 max-w-md w-full transform transition-all scale-100">
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