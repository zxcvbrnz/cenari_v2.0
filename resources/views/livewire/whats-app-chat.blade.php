<main class="py-14 md:py-20 md:px-6 grid grid-cols-1 gap-8">

    <div class="flex h-[600px] border rounded-lg bg-white overflow-hidden" wire:poll.3s>
        <!-- Sidebar: List Kontak -->
        <div class="w-1/3 border-r bg-gray-50 flex flex-col">
            <!-- Header Sidebar + Tombol Tambah Chat -->
            <div class="p-4 border-b bg-gray-100 font-bold text-gray-700 flex justify-between items-center">
                <span>Daftar Chat</span>
                <button wire:click="$set('showNewChatModal', true)"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white p-1.5 rounded-lg text-xs flex items-center gap-1 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Pesan Baru</span>
                </button>
            </div>

            <!-- List Kontak -->
            <div class="overflow-y-auto flex-1">
                @forelse($contacts as $contact)
                    <button wire:click="selectContact('{{ $contact->phone_number }}')"
                        class="w-full text-left p-3 border-b hover:bg-gray-100 transition {{ $selectedPhone === $contact->phone_number ? 'bg-blue-50 border-l-4 border-blue-500' : '' }}">
                        <p class="font-semibold text-gray-800">+{{ $contact->phone_number }}</p>
                        <p class="text-xs text-gray-500">
                            {{ \Carbon\Carbon::parse($contact->last_chat)->diffForHumans() }}
                        </p>
                    </button>
                @empty
                    <div class="p-4 text-center text-gray-400 text-sm">Belum ada pesan masuk</div>
                @endforelse
            </div>
        </div>

        <!-- Main Chat Window -->
        <div class="w-2/3 flex flex-col bg-gray-50">
            @if ($selectedPhone)
                <!-- Chat Header -->
                <div class="p-4 border-b bg-white font-bold text-gray-700 flex justify-between items-center">
                    <span>Chat: +{{ $selectedPhone }}</span>
                    <span
                        class="text-xs font-normal text-amber-600 bg-amber-50 px-2 py-1 rounded border border-amber-200">
                        Sesi Balas: 24 Jam Aktivitas
                    </span>
                </div>

                <!-- Chat Messages Area -->
                <div class="flex-1 p-4 overflow-y-auto flex flex-col space-y-3 bg-slate-100">
                    @if (session()->has('error'))
                        <div class="bg-red-100 text-red-700 p-2 text-sm rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    @forelse ($messages as $msg)
                        <div class="flex flex-col {{ $msg->direction === 'outbound' ? 'items-end' : 'items-start' }}">
                            <div
                                class="max-w-[70%] rounded-lg p-3 text-sm {{ $msg->direction === 'outbound' ? 'bg-emerald-600 text-white rounded-br-none' : 'bg-white text-gray-800 border rounded-bl-none shadow-sm' }}">
                                <p>{{ $msg->body }}</p>
                                <span class="text-[10px] block text-right mt-1 opacity-75">
                                    {{ $msg->created_at->format('H:i') }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="flex-1 flex items-center justify-center text-gray-400 text-sm">
                            Belum ada riwayat pesan. Ketik pesan di bawah untuk memulai percakapan.
                        </div>
                    @endforelse
                </div>

                <!-- Input & Reply Form -->
                <div class="p-3 bg-white border-t">
                    <form wire:submit.prevent="sendMessage" class="flex gap-2">
                        <input type="text" wire:model="replyMessage" placeholder="Ketik balasan pesan..."
                            class="flex-1 border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit"
                            class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                            Kirim
                        </button>
                    </form>
                </div>
            @else
                <!-- Empty State -->
                <div class="flex-1 flex items-center justify-center text-gray-400 text-sm">
                    Pilih salah satu nomor di sebelah kiri atau klik "Pesan Baru" untuk memulai chat.
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Tambah Chat Baru -->
    @if ($showNewChatModal)
        <div class="fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 relative">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Mulai Chat Baru</h3>

                <form wire:submit.prevent="openNewChat">
                    <div class="mb-4">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Nomor WhatsApp</label>
                        <input type="text" wire:model="newPhone" placeholder="Contoh: 628123456789"
                            class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('newPhone') border-red-500 @enderror">
                        @error('newPhone')
                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                        @enderror
                        <span class="text-[11px] text-gray-400 mt-1 block">Gunakan kode negara (contoh: 628xxx).</span>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" wire:click="$set('showNewChatModal', false)"
                            class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition">
                            Mulai Chat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</main>
