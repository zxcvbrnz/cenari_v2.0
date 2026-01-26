<div class="grid lg:grid-cols-3 gap-6 md:gap-8">
    <div class="lg:col-span-2 bg-white border border-slate-200 shadow-lg rounded-sm">
        <div class="text-slate-700 p-4">
            Data Peserta Didik
        </div>
        <hr />
        <div class="p-4">
            <div wire:ignore class="relative w-full h-[350px] md:h-[450px]" style=" margin: auto;">
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>
    <div class="bg-white border border-slate-200 shadow-lg rounded-sm">
        <div class="text-slate-700 p-4">
            Data Pendidikan Peserta Didik
        </div>
        <hr />
        <div class="p-4">
            <div wire:ignore style="width: 80%; margin: auto;">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
</div>
<script>
    var ctx = document.getElementById('barChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        // options: {
        //     scales: {
        //         y: {
        //             beginAtZero: true,
        //         }
        //     },
        //     interaction: {
        //         intersect: false,
        //     },
        // },
        data: {
            labels: @json($data['labels']),
            datasets: [{
                label: 'Data Peserta Baru/Aktif',
                data: @json($data['data']),
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgb(255, 99, 132)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }, {
                label: 'Data Peserta lulus/Nonaktif',
                data: @json($data['data2']),
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgb(255, 159, 64)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }, {
                label: 'Data Peserta Pelatihan Baru/Aktif',
                data: @json($data['data3']),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgb(54, 162, 235)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }, {
                label: 'Data Peserta Pelatihan lulus/Nonaktif',
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
    var ctx = document.getElementById('myChart').getContext('2d');
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'doughnut', // Mengubah 'pie' menjadi 'doughnut' agar lebih modern
        data: {
            labels: @json($data['label2']),
            datasets: [{
                label: 'Peserta didik',
                data: [
                    @json($data['SD']),
                    @json($data['SMP']),
                    @json($data['SMA']),
                    @json($data['DIPLOMAT']),
                    @json($data['S1']),
                    @json($data['S2']),
                    @json($data['S3']),
                ],
                backgroundColor: [
                    '#FF6384', // Merah muda
                    '#36A2EB', // Biru terang
                    '#FFCE56', // Kuning
                    '#1E3A8A', // Biru Navy
                    '#7C3AED', // Ungu
                    '#10B981', // Hijau Emerald
                    '#F59E0B', // Amber
                ],
                borderWidth: 2, // Ketebalan garis antar segmen
                borderColor: '#ffffff', // Warna garis putih agar terlihat bersih
                borderRadius: 5, // Membuat sudut segmen agak membulat
                hoverOffset: 20, // Memberikan efek "meledak" saat kursor di atas segmen
                spacing: 2, // Memberikan celah tipis antar segmen
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%', // Besarnya lubang tengah (semakin besar semakin tipis)
            plugins: {
                legend: {
                    position: 'bottom', // Pindahkan legenda ke bawah agar chart punya ruang lebar
                    labels: {
                        usePointStyle: true, // Bentuk legenda jadi lingkaran (lebih estetik)
                        padding: 20,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: true
                }
            },
            // Animasi saat chart muncul
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    });
</script>
