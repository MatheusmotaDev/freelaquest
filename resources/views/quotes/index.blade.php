<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Orçamentos</h2>
            <a href="{{ route('quotes.create') }}" class="bg-arcane hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow transition">+ Novo Orçamento</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                @if($quotes->count() > 0)
                    <div class="space-y-4">
                        @foreach($quotes as $quote)
                            <div class="flex justify-between items-center border-b border-gray-100 dark:border-gray-700 pb-4 last:border-0">
                                <div>
                                    <h3 class="font-bold text-lg text-gray-800 dark:text-white">{{ $quote->title }}</h3>
                                    <p class="text-sm text-gray-500">{{ $quote->client->name }} • R$ {{ number_format($quote->amount, 2, ',', '.') }}</p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="px-2 py-1 text-xs rounded-full font-bold {{ $quote->status === 'accepted' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ strtoupper($quote->status) }}
                                    </span>
                                    <a href="{{ route('quotes.show', $quote->id) }}" class="text-arcane hover:underline text-sm font-medium">Ver Detalhes</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-gray-500">Nenhum orçamento criado.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>