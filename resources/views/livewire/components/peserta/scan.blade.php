<div>
    <div class="flex items-center space-x-2 pb-4 px-4 sm:px-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 256 256">
            <path
                d="M224,40V80a8,8,0,0,1-16,0V48H176a8,8,0,0,1,0-16h40A8,8,0,0,1,224,40ZM80,208H48V176a8,8,0,0,0-16,0v40a8,8,0,0,0,8,8H80a8,8,0,0,0,0-16Zm136-40a8,8,0,0,0-8,8v32H176a8,8,0,0,0,0,16h40a8,8,0,0,0,8-8V176A8,8,0,0,0,216,168ZM40,88a8,8,0,0,0,8-8V48H80a8,8,0,0,0,0-16H40a8,8,0,0,0-8,8V80A8,8,0,0,0,40,88ZM80,72h96a8,8,0,0,1,8,8v96a8,8,0,0,1-8,8H80a8,8,0,0,1-8-8V80A8,8,0,0,1,80,72Zm8,96h80V88H88Z">
            </path>
        </svg>
        <div>
            <div>Scan untuk absen</div>
            <div class="text-xs text-slate-500">refresh halaman jika scanner tidak muncul</div>
        </div>
    </div>
    <hr>
    <div>
        <div x-on:scannerReset.window="initializeScanner()" id="reader" width="100%"></div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js" type="text/javascript">
    </script>
    <script>
        let scannerInitialized = false;
        let html5QrcodeScanner;

        function initializeScanner() {
            if (!scannerInitialized) {
                html5QrcodeScanner = new Html5QrcodeScanner(
                    "reader", {
                        fps: 10,
                        qrbox: {
                            width: 220,
                            height: 220
                        },
                        supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA],
                    },
                    false
                );
                html5QrcodeScanner.render(onScanSuccess, onScanFailure);
                scannerInitialized = true;
            }
        }

        initializeScanner();

        let scanSuccessful = false;

        function onScanSuccess(decodedText, decodedResult) {
            if (scanSuccessful) return;

            scanSuccessful = true;
            html5QrcodeScanner.clear();

            console.log(decodedText);
            @this.set('token_absen', decodedText);
            return Swal.fire({
                title: 'Create Absen',
                text: 'Yes Untuk Melanjutkan Absen?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('absen', decodedText);
                }
                scanSuccessful = false; // Reset flag after user interaction
                initializeScanner(); // Re-initialize scanner if needed
            });
        }

        function onScanFailure(error) {
            // handle scan failure, usually better to ignore and keep scanning.
        }
    </script>
</div>
