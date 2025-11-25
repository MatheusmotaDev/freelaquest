<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Analytics & Skill Tree
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <!-- Card do Gráfico -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Distribuição de Renda por Habilidade</h3>
                    
                    @if(count($chartData['data']) > 0)
                        <div class="relative h-64 w-full flex justify-center">
                            <canvas id="skillsChart"></canvas>
                        </div>
                    @else
                        <div class="text-center py-10 text-gray-400">
                            <p>Nenhum dado financeiro vinculado a tags ainda.</p>
                            <p class="text-xs mt-2">Receba um pagamento em um projeto com tags para ver o gráfico.</p>
                        </div>
                    @endif
                </div>

                <!-- Card de Insights (Texto) -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Top Habilidades (Rentabilidade)</h3>
                    
                    @if(count($chartData['data']) > 0)
                        <ul class="space-y-4">
                            @foreach($chartData['labels'] as $index => $label)
                                <li class="flex justify-between items-center border-b border-gray-100 dark:border-gray-700 pb-2">
                                    <div class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full" style="background-color: {{ $chartData['backgroundColor'][$index] }}"></span>
                                        <span class="text-gray-700 dark:text-gray-300 font-medium">{{ $label }}</span>
                                    </div>
                                    <span class="font-bold text-gray-900 dark:text-white">R$ {{ number_format($chartData['data'][$index], 2, ',', '.') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500 text-sm">Seus dados aparecerão aqui.</p>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <!-- Script do Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('skillsChart');
        
        if (ctx) {
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: @json($chartData['labels']),
                    datasets: [{
                        label: 'Ganhos (R$)',
                        data: @json($chartData['data']),
                        backgroundColor: @json($chartData['backgroundColor']),
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#9CA3AF', // Cor da legenda no dark mode
                                usePointStyle: true
                            }
                        }
                    }
                }
            });
        }
    </script>
</x-app-layout>