import './bootstrap';
import Swal from 'sweetalert2';

window.addEventListener('alert-success', (event) => {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000
    });

    Toast.fire({
        icon: 'success',
        title: event.detail.message
    })
})
window.addEventListener('alert-success-delete', (event) => {
    Swal.fire({
        title: "DIhapus!",
        text: event.detail.message,
        icon: "success"
    });
})
window.addEventListener('alert-success-1', (event) => {
    Swal.fire({
        title: "Berhasil!",
        text: event.detail.message,
        icon: "success"
    });
})

window.addEventListener('scannerReset', (event) => {
    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", {
        fps: 10,
        qrbox: {
            width: 220,
            height: 220
        }
    },
        false
    );
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
})
window.addEventListener('alert-fail', (event) => {
    Swal.fire({
        icon: "error",
        title: "Oops...",
        text: event.detail.message,
    });
})


function error() {
    Swal.fire({
        icon: 'warning',
        title: 'Middleware System!',
        text: 'ee'
    })
}

// Handler Midtrans untuk Livewire
document.addEventListener('livewire:init', () => {
    Livewire.on('payWithMidtrans', (data) => {
        // Cek apakah Snap sudah terload
        if (typeof window.snap === 'undefined') {
            console.error('Midtrans Snap.js belum terload. Pastikan script SDK ada di layout.');
            return;
        }

        // Jika data dikirim sebagai array/objek (Livewire 3 style)
        const token = Array.isArray(data) ? data[0].snapToken : data.snapToken;

        window.snap.pay(token, {
            onSuccess: function (result) {
                console.log('Payment Success:', result);
                window.location.reload();
            },
            onPending: function (result) {
                console.log('Payment Pending:', result);
                window.location.reload();
            },
            onError: function (result) {
                console.log('Payment Error:', result);
                window.location.reload();
            },
            onClose: function () {
                console.log('Customer closed the popup without finishing the payment');
            }
        });
    });
});