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