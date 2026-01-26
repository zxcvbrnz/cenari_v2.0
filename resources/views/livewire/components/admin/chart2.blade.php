<div class="grid gap-6 md:gap-8">
    <div class="bg-white border border-slate-200 shadow-lg rounded-sm">
        <div class="text-slate-700 p-4 flex justify-between items-center">
            <span>Data Perhitungan Program Perbulan Tahun {{ $year }}</span>

            <select wire:model.live="year" class="border border-violet-300 rounded px-2 py-1 text-sm">
                @php $currentYear = date('Y'); @endphp
                @for ($i = $currentYear; $i >= $currentYear - 5; $i--)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>
        <hr />
        <div class="p-4">
            <div style="width: 80%; margin: auto;">
                <canvas id="pesertaChart"></canvas>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        let ctx = document.getElementById('pesertaChart').getContext('2d');
        let myChart;

        // Fungsi helper untuk generate datasets
        function createDatasets(rawData) {
            return rawData.map((element) => ({
                label: element.nama,
                data: element.monthlyData,
                borderColor: `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 1)`,
                backgroundColor: `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.2)`,
                borderWidth: 1,
                fill: true,
                tension: 0.1
            }));
        }

        // Inisialisasi Chart Pertama Kali
        const initialData = {!! json_encode($data) !!};
        myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                    'Oktober', 'November', 'Desember'
                ],
                datasets: createDatasets(initialData)
            },
            options: {
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

        // Mendengarkan perubahan data dari Livewire (Event update-chart)
        $wire.on('update-chart', (event) => {
            myChart.data.datasets = createDatasets(event.data);
            myChart.update();
        });
    </script>
@endscript
