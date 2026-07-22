<main class="py-10 md:px-6 max-w-7xl mx-auto">

    <div class="flex h-[620px] border rounded-xl bg-white shadow-sm overflow-hidden" wire:poll.3s>

        <!-- ================= SIDEBAR: LIST KONTAK ================= -->
        <div class="w-1/3 border-r bg-gray-50 flex flex-col">
            <!-- Header Sidebar -->
            <div class="p-4 border-b bg-white flex justify-between items-center">
                <h2 class="font-bold text-gray-800 text-base">Chat WhatsApp</h2>
                <button wire:click="$set('showNewChatModal', true)"
                    class="bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white px-3 py-1.5 rounded-lg text-xs font-semibold flex items-center gap-1.5 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Pesan Baru</span>
                </button>
            </div>

            <!-- List Kontak -->
            <div class="overflow-y-auto flex-1 divide-y divide-gray-100">
                @forelse($contacts as $contact)
                    <button wire:click="selectContact('{{ $contact->phone_number }}')"
                        class="w-full text-left p-3.5 hover:bg-gray-100/80 transition flex flex-col gap-1 {{ $selectedPhone === $contact->phone_number ? 'bg-emerald-50/70 border-l-4 border-emerald-600' : '' }}">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-sm text-gray-800">+{{ $contact->phone_number }}</span>
                            <span class="text-[10px] text-gray-400">
                                {{ \Carbon\Carbon::parse($contact->last_chat)->diffForHumans() }}
                            </span>
                        </div>
                    </button>
                @empty
                    <div
                        class="p-8 text-center text-gray-400 text-sm flex flex-col items-center justify-center h-full gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-300" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <p>Belum ada riwayat pesan.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- ================= AREA UTAMA CHAT ================= -->
        <div class="w-2/3 flex flex-col bg-slate-50">
            @if ($selectedPhone)
                <!-- Chat Header -->
                <div
                    class="p-4 border-b bg-white font-semibold text-gray-800 flex justify-between items-center shadow-sm">
                    <div class="flex items-center gap-2">
                        <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></div>
                        <span>+{{ $selectedPhone }}</span>
                    </div>
                    <span class="text-xs text-amber-700 bg-amber-50 px-2.5 py-1 rounded-md border border-amber-200">
                        Batas Balas: 24 Jam Aktivitas
                    </span>
                </div>

                <!-- Chat Messages Area -->
                <div class="flex-1 p-4 overflow-y-auto flex flex-col space-y-3 bg-[#e5ddd5]/20">
                    @if (session()->has('error'))
                        <div class="bg-red-50 text-red-600 border border-red-200 p-3 text-xs rounded-lg mb-2">
                            {{ session('error') }}
                        </div>
                    @endif

                    @forelse ($messages as $msg)
                        <div class="flex flex-col {{ $msg->direction === 'outbound' ? 'items-end' : 'items-start' }}">
                            <div
                                class="max-w-[70%] rounded-xl px-3.5 py-2 text-sm shadow-sm {{ $msg->direction === 'outbound' ? 'bg-emerald-600 text-white rounded-tr-none' : 'bg-white text-gray-800 rounded-tl-none border border-gray-100' }}">
                                <p class="whitespace-pre-line leading-relaxed">{{ $msg->body }}</p>
                                <span class="text-[10px] block text-right mt-1 opacity-75">
                                    {{ $msg->created_at->format('H:i') }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="flex-1 flex flex-col items-center justify-center text-gray-400 text-xs gap-1">
                            <p>Belum ada percakapan dengan nomor ini.</p>
                            <p class="text-gray-400/80">Ketik pesan di bawah untuk memulai.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Form Input & Tombol Kirim -->
                <div class="p-3.5 bg-white border-t">
                    <form wire:submit.prevent="sendMessage" class="flex gap-2 items-center">
                        <input type="text" wire:model="replyMessage" wire:loading.attr="disabled"
                            wire:target="sendMessage" placeholder="Ketik balasan pesan..."
                            class="flex-1 border border-gray-300 rounded-lg px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 disabled:bg-gray-100">

                        <button type="submit" wire:loading.attr="disabled" wire:target="sendMessage"
                            class="bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white px-5 py-2 rounded-lg text-sm font-semibold transition flex items-center justify-center min-w-[90px] disabled:opacity-50 disabled:cursor-not-allowed">

                            <!-- Teks 'Kirim' HANYA tampil jika TIDAK sedang mengirim -->
                            <span wire:loading.remove wire:target="sendMessage">
                                Kirim
                            </span>

                            <!-- Teks 'Sending...' HANYA tampil SAAT sedang mengirim -->
                            <span wire:loading wire:target="sendMessage">
                                Sending...
                            </span>

                        </button>
                    </form>
                </div>
            @else
                <!-- Empty State Utama -->
                <div class="flex-1 flex flex-col items-center justify-center text-gray-400 gap-3">
                    <div class="p-4 bg-gray-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </div>
                    <div class="text-center">
                        <p class="font-semibold text-gray-600 text-sm">Tidak ada chat terpilih</p>
                        <p class="text-xs text-gray-400 mt-0.5">Pilih nomor di sebelah kiri atau buat pesan baru.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- ================= MODAL PESAN BARU ================= -->
    @if ($showNewChatModal)
        <div class="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6 relative">
                <h3 class="text-base font-bold text-gray-800 mb-1">Mulai Chat Baru</h3>
                <p class="text-xs text-gray-500 mb-4">Masukkan nomor WhatsApp tujuan yang ingin Anda hubungi.</p>

                <form wire:submit.prevent="openNewChat">
                    <div class="mb-4">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                        <input type="text" wire:model="newPhone" placeholder="Contoh: 08123456789 atau 628123456789"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('newPhone') border-red-500 @enderror">
                        @error('newPhone')
                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" wire:click="$set('showNewChatModal', false)"
                            class="px-4 py-2 text-xs font-semibold text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                            Batal
                        </button>
                        <button type="submit" wire:loading.attr="disabled" wire:target="openNewChat"
                            class="px-4 py-2 text-xs font-semibold text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition flex items-center gap-1.5">
                            <span wire:loading.remove wire:target="openNewChat">Lanjutkan</span>
                            <span wire:loading wire:target="openNewChat">Memproses...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</main>
