<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Meus Clientes
            </h2>
            <a href="{{ route('clients.create') }}" class="bg-arcane hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg text-sm transition shadow-lg transform hover:-translate-y-1">
                + Novo Cliente
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($clients->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($clients as $client)
                                <div class="group p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/30 hover:border-arcane transition relative">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center text-lg font-bold text-gray-500 dark:text-gray-300 group-hover:bg-arcane group-hover:text-white transition">
                                            {{ substr($client->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-lg leading-tight">{{ $client->name }}</h3>
                                            <p class="text-xs text-gray-500">{{ $client->company_name ?? 'Pessoa Física' }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 space-y-1 text-sm text-gray-600 dark:text-gray-400">
                                        <p>📧 {{ $client->email ?? 'Sem email' }}</p>
                                        <p>📱 {{ $client->phone ?? 'Sem telefone' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-10 text-gray-400">
                            <p>Nenhum cliente cadastrado ainda.</p>
                            <p class="text-sm">Cadastre o primeiro para começar!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>