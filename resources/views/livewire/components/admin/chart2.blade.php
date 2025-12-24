<!-- resources/views/livewire/peserta-chart.blade.php -->
<div class="grid gap-6 md:gap-8">
    <div class="bg-white border border-slate-200 shadow-lg rounded-sm">
        <div class="text-slate-700 p-4">
            Data Perhitungan Program Perbulan Tahun {{ $year }}
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
        const data = {!! json_encode($data) !!}; // Ubah cara Anda melakukan parse JSON
        var ctx = document.getElementById('pesertaChart').getContext('2d');
        var datasets = data.map((element) => ({ // Gunakan map untuk menghasilkan array datasets
            label: element.nama, // Gunakan nama mapel sebagai label
            data: element.monthlyData,
            borderColor: 'rgba(' + Math.floor(Math.random() * 255) + ', ' + Math.floor(Math.random() * 255) +
                ', ' + Math.floor(Math.random() * 255) + ', 1)',
            backgroundColor: 'rgba(' + Math.floor(Math.random() * 255) + ', ' + Math.floor(Math.random() *
                255) + ', ' + Math.floor(Math.random() * 255) + ', 0.2)',
            borderWidth: 1,
            fill: true,
            tension: 0.1
        }));

        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                    'Oktober', 'November', 'Desember'
                ],
                datasets: datasets // Gunakan datasets yang telah dibuat
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    }
                },
                interaction: {
                  intersect: false,
                },
            }
        });
    </script>
@endscript
