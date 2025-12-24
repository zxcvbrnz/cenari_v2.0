<div class="grid lg:grid-cols-3 gap-6 md:gap-8">
    <div class="lg:col-span-2 bg-white border border-slate-200 shadow-lg rounded-sm">
        <div class="text-slate-700 p-4">
            Data Peserta Didik
        </div>
        <hr />
        <div class="p-4">
            <div style="width: 80%; margin: auto;">
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
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                }
            },
            interaction: {
              intersect: false,
            },
        },
        data: {
            labels: @json($data['labels']),
            datasets: [{
                label: 'Data Peserta Baru/Aktif',
                data: @json($data['data']),
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgb(255, 99, 132)',
                borderWidth: 1,
                fill: true
            }, {
                label: 'Data Peserta lulus/Nonaktif',
                data: @json($data['data2']),
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgb(255, 159, 64)',
                borderWidth: 1,
                fill: true
            }, {
                label: 'Data Peserta Pelatihan Baru/Aktif',
                data: @json($data['data3']),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgb(54, 162, 235)',
                borderWidth: 1,
                fill: true
            }, {
                label: 'Data Peserta Pelatihan lulus/Nonaktif',
                data: @json($data['data4']),
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgb(153, 102, 255)',
                borderWidth: 1,
                fill: true
            }]
        },
    });
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
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
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)',
                    'rgb(0, 35, 121)',
                    'rgb(88, 40, 127)',
                    'rgb(64, 165, 120)',
                    'rgb(228, 143, 69)',
                ],
                hoverOffset: 4
            }]
        }
    });
</script>
