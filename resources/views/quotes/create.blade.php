<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Novo Orçamento Detalhado</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                
                <form method="POST" action="{{ route('quotes.store') }}" 
                      x-data="{ 
                          items: [{ description: '', quantity: 1, unit_price: 0 }],
                          addItem() { this.items.push({ description: '', quantity: 1, unit_price: 0 }); },
                          removeItem(index) { if(this.items.length > 1) this.items.splice(index, 1); },
                          calculateTotal() { return this.items.reduce((sum, item) => sum + (item.quantity * item.unit_price), 0); }
                      }">
                    @csrf
                    
                    <!-- Cabeçalho do Orçamento -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="md:col-span-1">
                            <x-input-label for="client_id" :value="__('Cliente')" />
                            <select id="client_id" name="client_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:border-arcane focus:ring-arcane">
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-1">
                            <x-input-label for="title" :value="__('Título do Projeto')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" required placeholder="Ex: E-commerce Completo" />
                        </div>

                        <!-- CAMPO NOVO (QUE ESTAVA FALTANDO) -->
                        <div class="md:col-span-1">
                            <x-input-label for="valid_until" :value="__('Válido Até')" />
                            <x-text-input id="valid_until" class="block mt-1 w-full" type="date" name="valid_until" :value="now()->addDays(15)->format('Y-m-d')" />
                        </div>
                    </div>

                    <div class="mb-6">
                        <x-input-label for="description" :value="__('Introdução / Escopo Geral')" />
                        <textarea name="description" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:border-arcane focus:ring-arcane" placeholder="Uma breve introdução sobre o projeto..."></textarea>
                    </div>

                    <!-- TABELA DINÂMICA DE ITENS -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mb-6">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Detalhamento de Custos</h3>
                        
                        <div class="space-y-3">
                            <!-- Cabeçalho da Tabela -->
                            <div class="hidden md:grid grid-cols-12 gap-2 text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                <div class="col-span-6">Descrição do Serviço/Item</div>
                                <div class="col-span-2">Qtd / Hrs</div>
                                <div class="col-span-3">Valor Unit. (R$)</div>
                                <div class="col-span-1 text-center">Ação</div>
                            </div>

                            <!-- Linhas (Loop Alpine) -->
                            <template x-for="(item, index) in items" :key="index">
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 items-start bg-gray-50 dark:bg-gray-700/20 p-3 rounded-lg">
                                    
                                    <div class="col-span-6">
                                        <input type="text" :name="'items['+index+'][description]'" x-model="item.description" required placeholder="Ex: Design da Home, Configuração de Servidor..." 
                                               class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white text-sm focus:ring-arcane focus:border-arcane">
                                    </div>

                                    <div class="col-span-2">
                                        <input type="number" :name="'items['+index+'][quantity]'" x-model="item.quantity" step="0.1" min="0" required 
                                               class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white text-sm focus:ring-arcane focus:border-arcane" placeholder="Qtd">
                                    </div>

                                    <div class="col-span-3">
                                        <input type="number" :name="'items['+index+'][unit_price]'" x-model="item.unit_price" step="0.01" min="0" required 
                                               class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white text-sm focus:ring-arcane focus:border-arcane" placeholder="R$ 0,00">
                                    </div>

                                    <div class="col-span-1 flex justify-center pt-1">
                                        <button type="button" @click="removeItem(index)" class="text-red-500 hover:text-red-700 transition p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                    
                                    <!-- Subtotal da Linha (Visual) -->
                                    <div class="col-span-12 text-right text-xs text-gray-500 mt-1 md:hidden">
                                        Total: R$ <span x-text="(item.quantity * item.unit_price).toFixed(2)"></span>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <button type="button" @click="addItem()" class="mt-4 text-sm text-arcane hover:underline font-bold flex items-center gap-1">
                            + Adicionar Item
                        </button>
                    </div>

                    <!-- Rodapé com Total -->
                    <div class="flex flex-col md:flex-row justify-between items-center border-t border-gray-200 dark:border-gray-700 pt-6">
                        <div class="text-sm text-gray-500">
                            O valor total é calculado automaticamente.
                        </div>
                        <div class="text-right">
                            <span class="text-gray-500 uppercase text-xs font-bold">Total Estimado</span>
                            <div class="text-3xl font-extrabold text-arcane">
                                R$ <span x-text="calculateTotal().toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })">0,00</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 mt-8">
                        <a href="{{ route('quotes.index') }}" class="px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-bold transition">Cancelar</a>
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-arcane to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold rounded-lg shadow-lg transition transform hover:-translate-y-1">
                            Gerar Orçamento Detalhado
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>