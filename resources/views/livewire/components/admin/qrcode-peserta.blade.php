<div class="py-8 px-6 flex flex-col items-center justify-center space-y-6">
    <div class="bg-white p-6 border border-gray-100 rounded-lg text-center">
        <div class="inline-block p-2 border border-gray-200 rounded-lg">
            {!! $qrcode !!}
        </div>

        <p class="mt-4 font-mono text-[10px] text-gray-500 break-all max-w-xs">
            ID: {{ $peserta->unique_code }}
        </p>

        <button wire:click="downloadQrCode" wire:loading.attr="disabled"
            class="mt-6 inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold py-2.5 px-6 rounded-lg transition shadow-md active:scale-95 disabled:opacity-75 disabled:cursor-not-allowed">

            <div wire:loading.remove>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
            </div>

            <div wire:loading class="hidden">
                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
            </div>

            <span wire:loading.remove>UNDUH QR CODE (SVG)</span>
            <span wire:loading class="hidden">MENYIAPKAN...</span>
        </button>
    </div>
</div>
