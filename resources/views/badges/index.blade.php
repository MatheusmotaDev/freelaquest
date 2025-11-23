<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Sala de Troféus
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Cabeçalho Gamer -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-8 mb-8 text-white shadow-lg flex items-center justify-between">
                <div>
                    <h3 class="text-3xl font-bold mb-2">Galeria de Conquistas</h3>
                    <p class="opacity-90">Colecione todas as medalhas para se tornar um Mestre Freelancer.</p>
                </div>
                <div class="text-right">
                    <p class="text-sm uppercase tracking-widest opacity-75">Total Desbloqueado</p>
                    <p class="text-4xl font-extrabold">{{ $user->badges->count() }} / {{ $allBadges->count() }}</p>
                </div>
            </div>

            <!-- Grid de Badges -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($allBadges as $badge)
                    @php
                        // Verifica se o usuário tem essa badge
                        $unlocked = $user->badges->contains($badge->id);
                    @endphp

                    <div class="relative bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border-2 {{ $unlocked ? 'border-victory dark:border-green-500/50' : 'border-gray-200 dark:border-gray-700 opacity-50 grayscale' }} transition hover:scale-105">
                        
                        @if($unlocked)
                            <div class="absolute top-2 right-2 text-xs font-bold text-white bg-victory px-2 py-1 rounded-full shadow-sm">
                                DESBLOQUEADO
                            </div>
                        @else
                            <div class="absolute top-2 right-2 text-xs font-bold text-gray-500 bg-gray-200 dark:bg-gray-700 px-2 py-1 rounded-full">
                                BLOQUEADO
                            </div>
                        @endif

                        <!-- Ícone (Emoji) -->
                        <div class="text-6xl mb-4 text-center block">
                            {{ $badge->icon_path }}
                        </div>

                        <h4 class="text-lg font-bold text-gray-800 dark:text-white text-center mb-2">
                            {{ $badge->name }}
                        </h4>
                        
                        <p class="text-sm text-gray-500 dark:text-gray-400 text-center min-h-[40px]">
                            {{ $badge->description }}
                        </p>

                        <div class="mt-4 text-center">
                            <span class="text-xs font-bold text-mystic bg-mystic/10 px-3 py-1 rounded-full">
                                +{{ $badge->xp_bonus }} XP
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>