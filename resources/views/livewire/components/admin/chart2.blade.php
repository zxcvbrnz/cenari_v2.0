<div class="grid gap-6 md:gap-8">
    <div class="bg-white border border-slate-200 shadow-lg rounded-sm">
        <div class="text-slate-700 p-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <span class="font-bold">Data Perhitungan Program Perbulan Tahun {{ $year }} -
                {{ $type }}</span>

            <div class="flex gap-2 w-full md:w-auto">
                <select wire:model.live="type"
                    class="border border-slate-300 rounded px-3 py-1 text-sm focus:ring-2 focus:ring-violet-500 outline-none w-full">
                    <option value="Private">Private</option>
                    <option value="Pelatihan">Pelatihan</option>
                </select>

                <select wire:model.live="year"
                    class="border border-slate-300 rounded px-3 py-1 text-sm focus:ring-2 focus:ring-violet-500 outline-none w-full">
                    @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <hr />
        <div class="p-4">
            <div wire:ignore class="relative w-full h-[350px] md:h-[450px]" style="margin: auto;">
                <canvas id="pesertaChart"></canvas>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        let myChart;
        const ctx = document.getElementById('pesertaChart').getContext('2d');

        function initChart(chartData) {
            if (myChart) {
                myChart.destroy();
            }

            const datasets = chartData.map((element) => ({
                label: element.nama,
                data: element.monthlyData,
                borderColor: `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 1)`,
                backgroundColor: `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.2)`,
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }));

            myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Penting agar tinggi container CSS dipatuhi
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 20
                            }
                        }
                    }
                }
            });
        }

        initChart({!! json_encode($data) !!});

        $wire.on('updateChartData', (event) => {
            initChart(event.chartData);
        });
    </script>
@endscript
