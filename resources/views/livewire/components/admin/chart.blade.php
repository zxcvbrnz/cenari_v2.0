<div class="grid lg:grid-cols-3 gap-6 md:gap-8">
    <div class="lg:col-span-2 bg-white border border-slate-200 shadow-lg rounded-sm">
        <div class="text-slate-700 p-4 font-bold border-b border-slate-100">
            Data Peserta Didik
        </div>
        <div class="p-4">
            <div wire:ignore class="relative h-[300px] md:h-[400px] w-full">
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>

    <div class="bg-white border border-slate-200 shadow-lg rounded-sm">
        <div class="text-slate-700 p-4 font-bold border-b border-slate-100">
            Data Pendidikan Peserta Didik
        </div>
        <div class="p-4">
            <div wire:ignore class="relative h-[300px] md:h-[400px] w-full">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
</div>
@script
    <script>
        // --- Chart 1: Line/Bar Chart ---
        const ctxBar = document.getElementById('barChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'line',
            data: {
                labels: @json($data['labels']),
                datasets: [{
                    label: 'Peserta Baru/Aktif',
                    data: @json($data['data']),
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgb(255, 99, 132)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3 // Membuat garis lebih halus
                }, {
                    label: 'Peserta Lulus/Nonaktif',
                    data: @json($data['data2']),
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    borderColor: 'rgb(255, 159, 64)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }, {
                    label: 'Pelatihan Baru/Aktif',
                    data: @json($data['data3']),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgb(54, 162, 235)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }, {
                    label: 'Pelatihan Lulus/Nonaktif',
                    data: @json($data['data4']),
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgb(153, 102, 255)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Penting untuk mobile
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            font: {
                                size: 11
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });

        // --- Chart 2: Pie Chart ---
        const ctxPie = document.getElementById('myChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: @json($data['label2']),
                datasets: [{
                    data: [
                        @json($data['SD']), @json($data['SMP']),
                        @json($data['SMA']),
                        @json($data['DIPLOMAT']), @json($data['S1']),
                        @json($data['S2']), @json($data['S3'])
                    ],
                    backgroundColor: [
                        '#FF6384', '#36A2EB', '#FFCE56', '#002379', '#58287F', '#40A578', '#E48F45'
                    ],
                    hoverOffset: 15
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            font: {
                                size: 10
                            },
                            padding: 15
                        }
                    }
                }
            }
        });
    </script>
@endscript
