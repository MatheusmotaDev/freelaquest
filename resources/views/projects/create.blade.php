<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Novo Projeto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <form method="POST" action="{{ route('projects.store') }}" class="space-y-6">
                        @csrf

                        <!-- 1. Nome do Projeto -->
                        <div>
                            <x-input-label for="title" :value="__('Título do Projeto')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus placeholder="Ex: E-commerce da Loja X" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- 2. Cliente (Select Dropdown) -->
                        <div>
                            <x-input-label for="client_id" :value="__('Cliente')" />
                            <select id="client_id" name="client_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="" disabled selected>Selecione um cliente...</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }} ({{ $client->company_name ?? 'Pessoa Física' }})</option>
                                @endforeach
                            </select>
                            
                            <!-- Aviso caso não existam clientes -->
                            @if($clients->isEmpty())
                                <p class="text-sm text-yellow-500 mt-2">
                                    Atenção: Você não tem clientes cadastrados. Crie os Seeds ou adicione um cliente manualmente no banco.
                                </p>
                            @endif
                            
                            <x-input-error :messages="$errors->get('client_id')" class="mt-2" />
                        </div>

                        <!-- 3. Tags (Skill Tree) - CORRIGIDO -->
                        <div class="border-t border-gray-100 dark:border-gray-700 pt-4">
                            <x-input-label :value="__('Habilidades Envolvidas (Skill Tree)')" class="mb-2" />
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                @foreach($tags as $tag)
                                    <div class="relative">
                                        <!-- O Input fica invisível, mas o ID e FOR garantem o clique -->
                                        <input type="checkbox" id="tag_{{ $tag->id }}" name="tags[]" value="{{ $tag->id }}" class="peer sr-only">
                                        
                                        <!-- O Label muda de cor quando o input (peer) está checado -->
                                        <label for="tag_{{ $tag->id }}" class="flex items-center justify-center px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-sm text-gray-600 dark:text-gray-400 cursor-pointer transition-all select-none peer-checked:border-indigo-500 peer-checked:bg-indigo-50 peer-checked:text-indigo-700 dark:peer-checked:bg-indigo-900/20 dark:peer-checked:text-indigo-300 peer-checked:font-bold hover:border-gray-300 dark:hover:border-gray-600">
                                            {{ $tag->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Selecione as tecnologias usadas. Isso gera seu gráfico de ganhos.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- 4. Valor (R$) -->
                            <div>
                                <x-input-label for="total_amount" :value="__('Valor Total (R$)')" />
                                <x-text-input id="total_amount" class="block mt-1 w-full" type="number" step="0.01" name="total_amount" :value="old('total_amount')" required placeholder="0.00" />
                                <x-input-error :messages="$errors->get('total_amount')" class="mt-2" />
                            </div>

                            <!-- 5. Prazo de Entrega -->
                            <div>
                                <x-input-label for="deadline" :value="__('Prazo de Entrega')" />
                                <x-text-input id="deadline" class="block mt-1 w-full" type="date" name="deadline" :value="old('deadline')" required />
                                <x-input-error :messages="$errors->get('deadline')" class="mt-2" />
                            </div>
                        </div>

                        <!-- 6. Descrição -->
                        <div>
                            <x-input-label for="description" :value="__('Descrição / Escopo')" />
                            <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" placeholder="Descreva os detalhes do que será feito...">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Botões de Ação -->
                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 underline">
                                Cancelar
                            </a>
                            
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg shadow-indigo-500/30 transition transform hover:-translate-y-1">
                                Salvar Projeto
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>