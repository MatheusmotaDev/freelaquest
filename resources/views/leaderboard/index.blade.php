<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            <span>🏆</span> Leaderboard & Competição
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- SEÇÃO 1: MEU STATUS E GRÁFICO -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card do Meu Status -->
                <div class="bg-gradient-to-br from-arcane to-blue-800 rounded-2xl p-6 text-white shadow-xl flex flex-col justify-between relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full blur-xl"></div>
                    
                    <div>
                        <p class="text-blue-200 text-sm uppercase tracking-widest font-bold">Minha Posição Global</p>
                        <div class="flex items-baseline gap-2 mt-2">
                            <span class="text-5xl font-extrabold">#{{ $myRank }}</span>
                            <span class="text-lg opacity-75">do mundo</span>
                        </div>
                    </div>

                    <div class="mt-8">
                        <div class="flex justify-between items-end mb-1">
                            <span class="text-sm font-bold">Nível {{ Auth::user()->current_level }}</span>
                            <span class="text-xs opacity-75">{{ Auth::user()->current_xp }} XP Total</span>
                        </div>
                        <!-- Barra de XP -->
                        <div class="w-full bg-black/20 rounded-full h-2">
                            <div class="bg-victory h-2 rounded-full shadow-[0_0_10px_#3DDC84]" style="width: {{ Auth::user()->xp_progress }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Gráfico de Evolução (Ocupa 2 colunas) -->
                <div class="md:col-span-2 bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Minha Evolução de XP (6 Meses)</h3>
                    <div class="h-40 w-full">
                        <canvas id="xpChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- SEÇÃO 2: OS RANKINGS -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- COLUNA ESQUERDA: RANKING GLOBAL (ALL TIME) -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                            <span class="text-2xl">🌍</span> Ranking Global
                        </h3>
                        <p class="text-sm text-gray-500">Os maiores níveis da história do FreelaQuest.</p>
                    </div>
                    
                    <div class="p-0">
                        @foreach($globalRanking as $index => $user)
                            <div class="flex items-center justify-between p-4 border-b border-gray-100 dark:border-gray-700 last:border-0 {{ $user->id === Auth::id() ? 'bg-arcane/10 border-l-4 border-l-arcane' : '' }}">
                                <div class="flex items-center gap-4">
                                    <!-- Medalhas para Top 3 -->
                                    <div class="w-8 text-center font-bold text-lg {{ $index === 0 ? 'text-yellow-500 text-2xl' : ($index === 1 ? 'text-gray-400 text-xl' : ($index === 2 ? 'text-orange-600 text-xl' : 'text-gray-500')) }}">
                                        {{ $index + 1 }}
                                    </div>
                                    
                                    <!-- Avatar -->
                                    <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-300 font-bold">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>

                                    <div>
                                        <p class="font-bold text-gray-800 dark:text-white {{ $user->id === Auth::id() ? 'text-arcane' : '' }}">
                                            {{ $user->name }}
                                            @if($user->id === Auth::id()) <span class="text-xs bg-arcane text-white px-2 py-0.5 rounded ml-2">VOCÊ</span> @endif
                                        </p>
                                        <p class="text-xs text-gray-500">Nível {{ $user->current_level }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="font-bold text-arcane block">{{ number_format($user->current_xp, 0, ',', '.') }} XP</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- COLUNA DIREITA: COMPETIÇÃO MENSAL -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden relative">
                    <!-- Fundo Decorativo para Competição -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-yellow-400/20 to-transparent rounded-bl-full pointer-events-none"></div>

                    <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                            <span class="text-2xl">🔥</span> Freelancer do Mês
                        </h3>
                        <p class="text-sm text-gray-500">Quem mais faturou em {{ now()->translatedFormat('F') }}.</p>
                    </div>

                    <div class="p-0">
                        @if($monthlyRanking->isEmpty())
                            <div class="p-8 text-center text-gray-400">
                                <p>Ninguém pontuou este mês ainda.</p>
                                <p class="text-sm">Seja o primeiro!</p>
                            </div>
                        @else
                            @foreach($monthlyRanking as $index => $user)
                                <div class="flex items-center justify-between p-4 border-b border-gray-100 dark:border-gray-700 last:border-0">
                                    <div class="flex items-center gap-4">
                                        <div class="w-8 text-center font-bold text-lg {{ $index === 0 ? 'text-yellow-500' : 'text-gray-400' }}">
                                            {{ $index + 1 }}
                                        </div>
                                        
                                        <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-300 font-bold">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>

                                        <div>
                                            <p class="font-bold text-gray-800 dark:text-white">{{ $user->name }}</p>
                                            @if($index === 0) 
                                                <span class="text-[10px] uppercase font-bold text-white bg-yellow-500 px-2 py-0.5 rounded">LÍDER</span> 
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="font-bold text-green-600 dark:text-green-400 block">+{{ number_format($user->monthly_xp, 0, ',', '.') }} XP</span>
                                        <span class="text-xs text-gray-400">este mês</span>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Script do Gráfico -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('xpChart');
        
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($historyLabels),
                    datasets: [{
                        label: 'XP Ganho',
                        data: @json($historyData),
                        borderColor: '#5865F2', // Azul Arcano
                        backgroundColor: 'rgba(88, 101, 242, 0.1)',
                        borderWidth: 3,
                        tension: 0.4, // Curva suave
                        fill: true,
                        pointBackgroundColor: '#7B4AEE',
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(200, 200, 200, 0.1)' }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        }
    </script>
</x-app-layout>