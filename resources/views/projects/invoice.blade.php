<x-app-layout>
    <!-- CSS para Impressão (Esconde menus e ajusta tamanho) -->
    <style>
        @media print {
            @page { margin: 0; size: auto; }
            body { background: white; margin: 0; }
            body * { visibility: hidden; }
            #invoice-area, #invoice-area * { visibility: visible; }
            #invoice-area { position: absolute; left: 0; top: 0; width: 100%; margin: 0; padding: 0; border: none; }
            .no-print { display: none !important; }
            nav, header, footer { display: none !important; }
        }
    </style>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Botões de Ação -->
            <div class="flex justify-between items-center mb-6 no-print px-4 sm:px-0">
                <a href="{{ route('projects.show', $project->id) }}" class="text-gray-500 hover:text-gray-700 underline">
                    &larr; Voltar ao Projeto
                </a>
                <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                    Imprimir / Salvar PDF
                </button>
            </div>

            <!-- ÁREA DO DOCUMENTO (RECIBO) -->
            <div id="invoice-area" class="bg-white text-gray-900 shadow-2xl p-12 min-h-[800px] relative border border-gray-200">
                
                <!-- Cabeçalho Fiscal -->
                <div class="border-b-2 border-gray-800 pb-6 mb-8 flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-black uppercase tracking-widest text-gray-800">Recibo de Serviços</h1>
                        <p class="text-sm text-gray-500 mt-1">Documento Auxiliar de Prestação de Serviço</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-xl text-gray-800">Nº {{ str_pad($project->id, 6, '0', STR_PAD_LEFT) }}/{{ now()->year }}</p>
                        <p class="text-sm text-gray-500">Emissão: {{ now()->format('d/m/Y') }}</p>
                    </div>
                </div>

                <!-- Prestador e Tomador -->
                <div class="grid grid-cols-2 gap-12 mb-12">
                    <!-- Prestador -->
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase mb-2 border-b border-gray-200 pb-1">Prestador de Serviços</h3>
                        <p class="font-bold text-lg">{{ Auth::user()->name }}</p>
                        <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                        <p class="text-sm text-gray-600">Profissional Autônomo / Freelancer</p>
                    </div>

                    <!-- Tomador -->
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase mb-2 border-b border-gray-200 pb-1">Tomador (Cliente)</h3>
                        <p class="font-bold text-lg">{{ $project->client->name }}</p>
                        @if($project->client->company_name)
                            <p class="text-sm text-gray-600">{{ $project->client->company_name }}</p>
                        @endif
                        <p class="text-sm text-gray-600">{{ $project->client->email }}</p>
                        <p class="text-sm text-gray-600">{{ $project->client->document ?? 'CPF/CNPJ não informado' }}</p>
                    </div>
                </div>

                <!-- Descrição dos Serviços -->
                <div class="mb-12">
                    <h3 class="text-xs font-bold text-gray-400 uppercase mb-4 border-b border-gray-200 pb-1">Discriminação dos Serviços</h3>
                    
                    <div class="bg-gray-50 p-6 rounded border border-gray-100">
                        <h4 class="font-bold text-gray-800 mb-2">{{ $project->title }}</h4>
                        <p class="text-sm text-gray-600 whitespace-pre-line mb-4">{{ $project->description }}</p>
                        
                        <!-- Tags usadas -->
                        @if($project->tags->count() > 0)
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <p class="text-xs text-gray-400 mb-1">Tecnologias/Serviços:</p>
                                <p class="text-sm text-gray-700">
                                    {{ $project->tags->pluck('name')->join(', ') }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Valores -->
                <div class="mb-16">
                    <table class="w-full text-right">
                        <tbody>
                            <tr>
                                <td class="py-2 text-gray-500 w-3/4">Valor Bruto dos Serviços</td>
                                <td class="py-2 text-gray-800 font-medium w-1/4">R$ {{ number_format($project->total_amount, 2, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="py-2 text-gray-500">Descontos / Impostos Retidos</td>
                                <td class="py-2 text-gray-800 font-medium">- R$ 0,00</td>
                            </tr>
                            <tr class="border-t-2 border-gray-800">
                                <td class="py-4 text-gray-800 font-bold uppercase text-sm">Valor Líquido a Receber</td>
                                <td class="py-4 text-2xl font-black text-gray-900">R$ {{ number_format($project->total_amount, 2, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Declaração -->
                <div class="mb-12 text-xs text-gray-500 text-justify leading-relaxed">
                    <p>
                        Declaro que os serviços acima discriminados foram prestados e finalizados conforme acordado.
                        Este recibo tem valor legal de comprovação de pagamento e execução de serviço para fins de controle financeiro entre as partes.
                        O pagamento foi realizado/agendado conforme as faturas vinculadas a este projeto.
                    </p>
                </div>

                <!-- Assinatura -->
                <div class="absolute bottom-12 left-12 right-12">
                    <div class="flex justify-between">
                        <div class="text-center">
                            <div class="w-64 border-b border-gray-400 mb-2"></div>
                            <p class="text-xs font-bold uppercase text-gray-400">Assinatura do Prestador</p>
                        </div>
                        <!-- Espaço vazio ou data -->
                        <div class="text-right flex items-end">
                            <p class="text-sm font-bold text-gray-400">Data: ____/____/______</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>