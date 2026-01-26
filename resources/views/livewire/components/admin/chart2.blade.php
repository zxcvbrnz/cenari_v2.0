<div class="grid gap-6 md:gap-8">
    <div class="bg-white border border-slate-200 shadow-lg rounded-sm">
        <div class="text-slate-700 p-4 flex justify-between items-center">
            <span class="font-bold uppercase tracking-tight text-sm">Data Perhitungan Program Perbulan</span>

            <select wire:model.live="year"
                class="text-sm border-gray-300 rounded-lg focus:ring-violet-500 focus:border-violet-500">
                @php
                    $startYear = 2020; // Tahun awal sistem
                    $currentYear = date('Y');
                @endphp
                @for ($y = $currentYear; $y >= $startYear; $y--)
                    <option value="{{ $y }}">Tahun {{ $y }}</option>
                @endfor
            </select>
        </div>
        <hr />
        <div class="p-4">
            <div style="width: 100%; height: 400px; margin: auto;">
                <canvas id="pesertaChart"></canvas>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        var ctx = document.getElementById('pesertaChart').getContext('2d');
        var myChart;

        // Fungsi untuk membuat dataset dari data mentah
        function createDatasets(rawData) {
            return rawData.map((element) => {
                const r = Math.floor(Math.random() * 200); // Batasi ke 200 agar warna tidak terlalu terang
                const g = Math.floor(Math.random() * 200);
                const b = Math.floor(Math.random() * 200);
                return {
                    label: element.nama,
                    data: element.monthlyData,
                    borderColor: `rgba(${r}, ${g}, ${b}, 1)`,
                    backgroundColor: `rgba(${r}, ${g}, ${b}, 0.1)`,
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4 // Membuat garis lebih halus
                };
            });
        }

        // Inisialisasi Chart Pertama Kali
        myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: createDatasets($wire.data)
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });

        // Listen event dari Livewire untuk update data
        $wire.on('update-chart', ({
            data
        }) => {
            myChart.data.datasets = createDatasets(data);
            myChart.update();
        });
    </script>
@endscript
