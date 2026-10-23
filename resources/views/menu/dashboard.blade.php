<x-layouts.app title="Dashboard">

<div class="w-full max-w-5xl mx-auto py-4">
    
    <!-- CARD UTAMA -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden mb-6 transition-colors duration-300">
        
        <!-- HEADER -->
        <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 text-center">
            <h5 class="text-lg font-bold text-slate-900 dark:text-white mb-0">Statistik Akun Media Sosial</h5>
        </div>

        <!-- BODY -->
        <div class="p-6">

            {{-- ================= TOTAL & PROVIDER CARDS ================= --}}
            <div class="flex flex-wrap justify-center gap-4 mb-8">

                {{-- Total --}}
                <div class="w-[130px] bg-slate-50 dark:bg-slate-800/50 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-4 text-center transition-colors">
                    <h5 class="text-2xl font-bold text-blue-600 dark:text-blue-400 mb-1">{{ $totalAccounts }}</h5>
                    <small class="text-slate-500 dark:text-slate-400 text-sm">Total Akun</small>
                </div>

                {{-- Provider --}}
                @foreach(['google', 'facebook', 'github', 'x', 'discord'] as $provider)
                <div class="w-[130px] bg-slate-50 dark:bg-slate-800/50 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-4 text-center transition-colors">
                    <h6 class="text-xl font-bold text-slate-900 dark:text-white mb-1">{{ $providerCounts[$provider] }}</h6>
                    <small class="text-slate-500 dark:text-slate-400 text-sm capitalize">{{ $provider }}</small>
                </div>
                @endforeach

            </div>

            {{-- ================= CHART SECTION ================= --}}
            <div class="flex flex-col items-center">
                
                {{-- Toggle Tombol --}}
                <div class="flex justify-center gap-3 mb-5">
                    <button class="px-4 py-1.5 text-sm font-medium text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50 dark:text-blue-400 dark:border-blue-400 dark:hover:bg-blue-900/20 transition-colors" 
                        onclick="changeChart('bar')">
                        Bar
                    </button>

                    <button class="px-4 py-1.5 text-sm font-medium text-emerald-600 border border-emerald-600 rounded-lg hover:bg-emerald-50 dark:text-emerald-400 dark:border-emerald-400 dark:hover:bg-emerald-900/20 transition-colors" 
                        onclick="changeChart('pie')">
                        Pie
                    </button>
                </div>

                {{-- Container Chart --}}
                <div class="w-full max-w-2xl bg-slate-50 dark:bg-slate-800/50 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-4 transition-colors">
                    <div class="relative w-full h-[300px]">
                        <canvas id="providerChart"></canvas>
                    </div>
                </div>

            </div>

        </div>
    </div>

</div>

{{-- ================= CHART JS ================= --}}
{{-- Kode JavaScript TIDAK DIUBAH sama sekali --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const ctx = document.getElementById('providerChart').getContext('2d');
    const chartData = @json($chartData);

    let currentChart;

    function renderChart(type) {

        if (currentChart) {
            currentChart.destroy();
        }

        currentChart = new Chart(ctx, {
            type: type,
            data: {
                labels: chartData.labels,
                datasets: [{
                    data: chartData.data,
                    backgroundColor: chartData.backgroundColor,
                    borderRadius: type === 'bar' ? 6 : 0,
                    hoverOffset: type === 'pie' ? 10 : 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: type === 'pie',
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.raw + ' akun';
                            }
                        }
                    }
                },
                scales: type === 'bar' ? {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                } : {}
            }
        });
    }

    renderChart('bar');

    window.changeChart = function(type) {
        renderChart(type);
    };

});
</script>

</x-layouts.app>