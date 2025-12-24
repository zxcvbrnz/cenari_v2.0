<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Aplikasi Absensi Cenari Education Center') }}</title>

    <!--Regular Datatables CSS-->
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
    <!--Responsive Extension Datatables CSS-->
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-gray-100">
        <livewire:layout.navigation />
        <livewire:layout.sidebar />

        {{-- <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif --}}

        <!-- Page Content -->
        <main class="p-4 sm:ml-64 pt-8">
            {{ $slot }}
        </main>
    </div>

    <!-- jQuery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <!--Datatables -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script>
        // $(document).ready(function() {
        //     var table = $('.dat-table').DataTable({
        //             responsive: true
        //         })
        //         .columns.adjust()
        //         .responsive.recalc();
        // });

        // function initializeDataTable1() {
        //     $(document).ready(function() {
        //         var table = $('.dat-table-1').DataTable({
        //                 responsive: true
        //             })
        //             .columns.adjust()
        //             .responsive.recalc();
        //     });
        // }

        // function initializeDataTable2() {
        //     $(document).ready(function() {
        //         var table = $('.dat-table-2').DataTable({
        //                 responsive: true
        //             })
        //             .columns.adjust()
        //             .responsive.recalc();
        //     });
        // }

        // function initializeDataTablePembayaran() {
        //     $(document).ready(function() {
        //         var table = $('#tablePembayaran').DataTable({
        //                 responsive: true
        //             })
        //             .columns.adjust()
        //             .responsive.recalc();
        //     });
        // }
        // initializeDataTablePembayaran();
        // initializeDataTable();
        // initializeDataTable1();
        // initializeDataTable2();

        // window.addEventListener('reload-table', (event) => {
        //     initializeDataTable();
        // });
        // window.addEventListener('reload-table-pembayaran', (event) => {
        //     initializeDataTablePembayaran();
        // });
        // window.addEventListener('reload-table-1', (event) => {
        //     initializeDataTable1();
        // });
        // window.addEventListener('reload-table-2', (event) => {
        //     initializeDataTable2();
        // });
    </script>
    @livewireScripts
</body>

</html>
