<div class="grid gap-6 md:gap-8">
    <div class="bg-white border border-slate-200 shadow-lg rounded-sm">
        <div class="text-slate-700 p-4 flex justify-between items-center">
            <span>Data Perhitungan Program Perbulan Tahun {{ $year }}</span>

            <select wire:model.live="year"
                class="border border-slate-300 rounded px-3 py-1 text-sm focus:ring-2 focus:ring-violet-500 outline-none">
                @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>
        <hr />
        <div class="p-4">
            <div wire:ignore style="width: 80%; margin: auto;">
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
                borderWidth: 1,
                fill: true,
                tension: 0.1
            }));

            myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                        'Oktober', 'November', 'Desember'
                    ],
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    interaction: {
                        intersect: false
                    }
                }
            });
        }

        // Render pertama kali
        initChart({!! json_encode($data) !!});

        // Mendengarkan event dari PHP untuk update data tanpa refresh halaman
        $wire.on('updateChartData', (event) => {
            initChart(event.chartData);
        });
    </script>
@endscript
