<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Novo Comunicado (Admin)
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                
                <form method="POST" action="{{ route('announcements.store') }}" class="space-y-6">
                    @csrf

                    
                    <div>
                        <x-input-label for="title" :value="__('Título do Aviso')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" required autofocus placeholder="Ex: Manutenção Programada" />
                    </div>

                    
                    <div>
                        <x-input-label for="type" :value="__('Tipo de Comunicado')" />
                        <select id="type" name="type" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:border-arcane focus:ring-arcane">
                            <option value="info">📢 Informação Geral</option>
                            <option value="update">🚀 Atualização do Sistema</option>
                            <option value="alert">⚠️ Alerta Importante</option>
                        </select>
                    </div>

                    
                    <div>
                        <x-input-label for="content" :value="__('Mensagem')" />
                        <textarea id="content" name="content" rows="6" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:border-arcane focus:ring-arcane" required placeholder="Digite a mensagem aqui..."></textarea>
                    </div>

                    
                    <div class="flex justify-end gap-4 border-t border-gray-100 dark:border-gray-700 pt-4">
                        <a href="{{ route('announcements.index') }}" class="px-4 py-2 text-gray-600 dark:text-gray-400 hover:underline">Cancelar</a>
                        <button type="submit" class="bg-arcane hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg shadow transition">
                            Publicar
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>