<div>
    @if (auth()->user()->role === 'admin')
        <div class="bg-white border border-slate-200 shadow-lg rounded-sm">
            <div class="text-slate-700 p-4">
                Masukan dan Saran Masuk
            </div>
            <hr />
            <div class="p-4">
                @if ($masukans->count() > 0)
                    @foreach ($masukans as $masukan)
                        <div class="flex justify-between mb-4 border-b border-slate-400 py-2">
                            <div>
                                <div class="flex items-center space-x-2 text-slate-600">
                                    <span>{{ $masukan->subject }}</span>
                                    @if (!$masukan->reply)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-600"
                                            fill="currentColor" viewBox="0 0 256 256">
                                            <path
                                                d="M225.86,102.82c-3.77-3.94-7.67-8-9.14-11.57-1.36-3.27-1.44-8.69-1.52-13.94-.15-9.76-.31-20.82-8-28.51s-18.75-7.85-28.51-8c-5.25-.08-10.67-.16-13.94-1.52-3.56-1.47-7.63-5.37-11.57-9.14C146.28,23.51,138.44,16,128,16s-18.27,7.51-25.18,14.14c-3.94,3.77-8,7.67-11.57,9.14C88,40.64,82.56,40.72,77.31,40.8c-9.76.15-20.82.31-28.51,8S41,67.55,40.8,77.31c-.08,5.25-.16,10.67-1.52,13.94-1.47,3.56-5.37,7.63-9.14,11.57C23.51,109.72,16,117.56,16,128s7.51,18.27,14.14,25.18c3.77,3.94,7.67,8,9.14,11.57,1.36,3.27,1.44,8.69,1.52,13.94.15,9.76.31,20.82,8,28.51s18.75,7.85,28.51,8c5.25.08,10.67.16,13.94,1.52,3.56,1.47,7.63,5.37,11.57,9.14C109.72,232.49,117.56,240,128,240s18.27-7.51,25.18-14.14c3.94-3.77,8-7.67,11.57-9.14,3.27-1.36,8.69-1.44,13.94-1.52,9.76-.15,20.82-.31,28.51-8s7.85-18.75,8-28.51c.08-5.25.16-10.67,1.52-13.94,1.47-3.56,5.37-7.63,9.14-11.57C232.49,146.28,240,138.44,240,128S232.49,109.73,225.86,102.82Zm-11.55,39.29c-4.79,5-9.75,10.17-12.38,16.52-2.52,6.1-2.63,13.07-2.73,19.82-.1,7-.21,14.33-3.32,17.43s-10.39,3.22-17.43,3.32c-6.75.1-13.72.21-19.82,2.73-6.35,2.63-11.52,7.59-16.52,12.38S132,224,128,224s-9.15-4.92-14.11-9.69-10.17-9.75-16.52-12.38c-6.1-2.52-13.07-2.63-19.82-2.73-7-.1-14.33-.21-17.43-3.32s-3.22-10.39-3.32-17.43c-.1-6.75-.21-13.72-2.73-19.82-2.63-6.35-7.59-11.52-12.38-16.52S32,132,32,128s4.92-9.15,9.69-14.11,9.75-10.17,12.38-16.52c2.52-6.1,2.63-13.07,2.73-19.82.1-7,.21-14.33,3.32-17.43S70.51,56.9,77.55,56.8c6.75-.1,13.72-.21,19.82-2.73,6.35-2.63,11.52-7.59,16.52-12.38S124,32,128,32s9.15,4.92,14.11,9.69,10.17,9.75,16.52,12.38c6.1,2.52,13.07,2.63,19.82,2.73,7,.1,14.33.21,17.43,3.32s3.22,10.39,3.32,17.43c.1,6.75.21,13.72,2.73,19.82,2.63,6.35,7.59,11.52,12.38,16.52S224,124,224,128,219.08,137.15,214.31,142.11ZM120,136V80a8,8,0,0,1,16,0v56a8,8,0,0,1-16,0Zm20,36a12,12,0,1,1-12-12A12,12,0,0,1,140,172Z">
                                            </path>
                                        </svg>
                                    @endif
                                </div>
                                <div class="text-slate-500 text-xs">dari : {{ $masukan->user->name }} ~
                                    <span class="font-bold">{{ $masukan->user->role }}</span>
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('masukan.detail', ['id' => $masukan->id]) }}" wire:navigate
                                    class="text-blue-600 hover:text-blue-800 underline text-sm">view</a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="flex justify-center">
                        <span class="text-sm text-slate-500">Belum terdapat Masukan dan Saran</span>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="bg-white border border-slate-200 shadow-lg rounded-sm">
            <div class="text-slate-700 p-4">
                Berikan Masukan dan Saran
            </div>
            <hr />
            <div class="p-4">
                <form wire:submit="createMasukan" class="grid gap-4 w-full lg:w-1/2">
                    <div>
                        <x-input-label class="required" for="subject" :value="__('Subjek')" />
                        <x-text-input wire:model="subject" id="subject" name="subject" type="text"
                            class="mt-1 block w-full" required />
                        <x-input-error class="mt-2" :messages="$errors->get('subject')" />
                    </div>
                    <div>
                        <x-input-label class="required" for="message" :value="__('Pesan')" />
                        <textarea name="" id="" rows="6" required wire:model="message"
                            class="w-full mt-1 block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm"></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('message')" />
                    </div>
                    <div>
                        <x-primary-button>{{ __('Kirim') }}</x-primary-button>
                    </div>
                </form>
            </div>
            <hr class="mt-6">
            <div class="text-slate-700 p-4">
                Masukan dan Saran Kamu
            </div>
            <hr />
            <div class="p-4 min-h-32">
                @if ($masukans->count() > 0)
                    @foreach ($masukans as $masukan)
                        <div x-data='{isOpen: false}'>
                            <div @click='isOpen = !isOpen'
                                class="w-full flex justify-between items-center py-3 px-8 bg-slate-50 border-b border-slate-200 cursor-pointer">
                                <div>
                                    <div>
                                        <h3 class="text-slate-700 font-bold flex items-center space-x-4">
                                            <span>{{ $masukan->subject }}</span>
                                            <span class="text-xs text-green-500 flex items-center space-x-1">
                                                @if ($masukan->reply)
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                                        fill="currentColor" viewBox="0 0 256 256">
                                                        <path
                                                            d="M149.61,85.71l-89.6,88a8,8,0,0,1-11.22,0L10.39,136a8,8,0,1,1,11.22-11.41L54.4,156.79l84-82.5a8,8,0,1,1,11.22,11.42Zm96.1-11.32a8,8,0,0,0-11.32-.1l-84,82.5-18.83-18.5a8,8,0,0,0-11.21,11.42l24.43,24a8,8,0,0,0,11.22,0l89.6-88A8,8,0,0,0,245.71,74.39Z">
                                                        </path>
                                                    </svg>
                                                    <span>dibaca</span>
                                                @endif
                                            </span>
                                        </h3>
                                    </div>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    :class="isOpen ? '-rotate-180' : ''" class="w-6 h-6 transition duration-300"
                                    viewBox="0 0 256 256">
                                    <path
                                        d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z">
                                    </path>
                                </svg>
                            </div>
                            <div x-show='isOpen' class="" x-cloak x-collapse>
                                <div class="py-4 px-8 grid lg:grid-cols-2 gap-4">
                                    <div>
                                        <div class="text-sm font-bold">Pesan :</div>
                                        <div class="text-slate-700">{{ $masukan->message }}</div>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold">Balasan :</div>
                                        <div class="text-slate-700">{{ $masukan->reply }}</div>
                                    </div>
                                </div>
                                @if (!$masukan->reply)
                                    <div class="px-8 py-2">
                                        <button onclick="hapusPesanJs({{ $masukan->id }})"
                                            class="text-red-600 hover:text-red-800 text-sm">hapus</button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="flex justify-center">
                        <span class="text-sm text-slate-500">Kamu belum memberikan Masukan dan Saran</span>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>

<script>
    function hapusPesanJs(id) {
        Swal.fire({
            title: 'Apakah Kamu yakin?',
            text: "Kamu akan menghapus pesan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call(`hapusPesan`, (id));
            }
        });
    }
</script>
