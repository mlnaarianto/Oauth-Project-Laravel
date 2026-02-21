<x-layouts.app title="Dashboard">

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white text-center">
                    <h5 class="mb-0">Statistik Akun Media Sosial</h5>
                </div>

                <div class="card-body">

                    {{-- ================= TOTAL & PROVIDER CARDS ================= --}}
                    <div class="row justify-content-center mb-4 g-3">

                        {{-- Total --}}
                        <div class="col-auto">
                            <div class="card text-center shadow-sm border-0" style="width:130px;">
                                <div class="card-body py-3">
                                    <h5 class="fw-bold text-primary mb-1">{{ $totalAccounts }}</h5>
                                    <small class="text-muted">Total Akun</small>
                                </div>
                            </div>
                        </div>

                        {{-- Provider --}}
                        @foreach(['google', 'facebook', 'github', 'x', 'discord'] as $provider)
                        <div class="col-auto">
                            <div class="card text-center shadow-sm border-0" style="width:130px;">
                                <div class="card-body py-3">
                                    <h6 class="fw-bold mb-1">{{ $providerCounts[$provider] }}</h6>
                                    <small class="text-muted text-capitalize">{{ $provider }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>

                    {{-- ================= CHART SECTION ================= --}}
                    <div class="row justify-content-center">
                        <div class="col-md-7">

                            {{-- Toggle --}}
                            <div class="text-center mb-3">
                                <button class="btn btn-sm btn-outline-primary me-2"
                                    onclick="changeChart('bar')">
                                    Bar
                                </button>

                                <button class="btn btn-sm btn-outline-success"
                                    onclick="changeChart('pie')">
                                    Pie
                                </button>
                            </div>

                            <div class="card shadow-sm border-0 p-3">
                                <canvas id="providerChart" height="200"></canvas>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


{{-- ================= CHART JS ================= --}}
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