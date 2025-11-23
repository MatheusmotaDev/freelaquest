<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            <span class="text-red-500">$</span> {{ __('Nova Despesa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <form method="POST" action="{{ route('expenses.store') }}" class="space-y-6">
                        @csrf

                        <!-- 1. Vincular a qual Projeto? -->
                        <div>
                            <x-input-label for="project_id" :value="__('Vincular ao Projeto')" />
                            <select id="project_id" name="project_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-500 focus:ring-red-500 dark:focus:ring-red-500 rounded-md shadow-sm" required>
                                <option value="" disabled selected>Selecione o projeto...</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->title }} (Cliente: {{ $project->client->name }})</option>
                                @endforeach
                            </select>
                            @if($projects->isEmpty())
                                <p class="text-sm text-red-400 mt-2">Você não tem projetos ativos para lançar despesas.</p>
                            @endif
                            <x-input-error :messages="$errors->get('project_id')" class="mt-2" />
                        </div>

                        <!-- 2. Descrição do Gasto -->
                        <div>
                            <x-input-label for="description" :value="__('Descrição do Gasto')" />
                            <x-text-input id="description" class="block mt-1 w-full focus:border-red-500 focus:ring-red-500" type="text" name="description" :value="old('description')" required placeholder="Ex: Uber para reunião, Hospedagem AWS, Café..." />
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- 3. Valor -->
                            <div>
                                <x-input-label for="amount" :value="__('Valor (R$)')" />
                                <x-text-input id="amount" class="block mt-1 w-full focus:border-red-500 focus:ring-red-500" type="number" step="0.01" name="amount" :value="old('amount')" required placeholder="0.00" />
                                <p class="text-xs text-gray-500 mt-1">Isso será descontado do lucro do projeto.</p>
                                <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                            </div>

                            <!-- 4. Data -->
                            <div>
                                <x-input-label for="incurred_date" :value="__('Data da Despesa')" />
                                <x-text-input id="incurred_date" class="block mt-1 w-full focus:border-red-500 focus:ring-red-500" type="date" name="incurred_date" :value="old('incurred_date', date('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('incurred_date')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Botões -->
                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 underline">
                                Cancelar
                            </a>
                            
                            <button type="submit" class="bg-white dark:bg-gray-700 text-red-500 border border-red-200 dark:border-red-800 font-bold py-2 px-6 rounded-lg hover:bg-red-50 dark:hover:bg-gray-600 transition">
                                Registrar Despesa
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>