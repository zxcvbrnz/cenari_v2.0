<div>
    <form wire:submit="postNilaiPeserta" class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 mb-4">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 w-4/5">
                        Materi
                    </th>
                    <th scope="col" class="px-6 py-3 w-1/5">
                        Nilai
                    </th>
                </tr>
            </thead>
            <tbody>
                @php
                    $pp = $status === 'nonaktif' ? true : false;
                @endphp
                @foreach (range(1, 10) as $i)
                    <tr class="bg-white border-b">
                        <th scope="row">
                            <x-text-input wire:model="postNilai.materi_{{ $i }}" type="text"
                                class="mt-1 block w-full" :readonly="$pp"  />
                        </th>
                        <td scope="row">
                            <x-text-input wire:model="postNilai.nilai_{{ $i }}" type="number"
                                class="mt-1 block w-full" :readonly="$pp" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if($status === 'aktif')
            <x-primary-button>Simpan</x-primary-button>
        @endif
    </form>
</div>
