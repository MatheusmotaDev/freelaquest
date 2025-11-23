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
                    
                    <!-- Formulário de Criação -->
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
                            <select id="client_id" name="client_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-arcane dark:focus:border-arcane focus:ring-arcane dark:focus:ring-arcane rounded-md shadow-sm">
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

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- 3. Valor (R$) -->
                            <div>
                                <x-input-label for="total_amount" :value="__('Valor Total (R$)')" />
                                <x-text-input id="total_amount" class="block mt-1 w-full" type="number" step="0.01" name="total_amount" :value="old('total_amount')" required placeholder="0.00" />
                                <x-input-error :messages="$errors->get('total_amount')" class="mt-2" />
                            </div>

                            <!-- 4. Prazo de Entrega -->
                            <div>
                                <x-input-label for="deadline" :value="__('Prazo de Entrega')" />
                                <x-text-input id="deadline" class="block mt-1 w-full" type="date" name="deadline" :value="old('deadline')" required />
                                <x-input-error :messages="$errors->get('deadline')" class="mt-2" />
                            </div>
                        </div>

                        <!-- 5. Descrição -->
                        <div>
                            <x-input-label for="description" :value="__('Descrição / Escopo')" />
                            <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-arcane dark:focus:border-arcane focus:ring-arcane dark:focus:ring-arcane rounded-md shadow-sm" placeholder="Descreva os detalhes do que será feito...">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Botões de Ação -->
                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 underline">
                                Cancelar
                            </a>
                            
                            <button type="submit" class="bg-arcane hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg shadow-arcane/30 transition transform hover:-translate-y-1">
                                Salvar Projeto
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>