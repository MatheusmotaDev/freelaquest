<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Novo Orçamento</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <form method="POST" action="{{ route('quotes.store') }}" class="space-y-6">
                    @csrf
                    
                    <div>
                        <x-input-label for="title" :value="__('Título da Proposta')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" required placeholder="Ex: Desenvolvimento de Site Institucional" />
                    </div>

                    <div>
                        <x-input-label for="client_id" :value="__('Cliente')" />
                        <select id="client_id" name="client_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:border-arcane focus:ring-arcane">
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                        @if($clients->isEmpty())
                            <p class="text-sm text-red-500 mt-1">Cadastre um cliente primeiro.</p>
                        @endif
                    </div>

                    <div>
                        <x-input-label for="amount" :value="__('Valor Total (R$)')" />
                        <x-text-input id="amount" class="block mt-1 w-full" type="number" step="0.01" name="amount" required />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Descrição / Escopo')" />
                        <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:border-arcane focus:ring-arcane"></textarea>
                    </div>

                    <div class="flex justify-end gap-4 pt-4">
                        <a href="{{ route('quotes.index') }}" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 underline pt-2">Cancelar</a>
                        <button type="submit" class="bg-arcane hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg transition">
                            Criar Orçamento
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>