<x-app-layout :pageHeader="$pageHeader" :assets="$assets ?? []" :dir="false">
    <div class="card mt-2">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Lihat Data Laporan Komparasi</h4>
            </div>
            <div class="card-action">
                <a href="{{route('laporan-komparasi.index')}}" class="btn btn-sm btn-warning" role="button">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $data->preorder->proyek->nama }} - Minggu ke {{ $data->preorder->minggu_ke }}</p>
            <p><strong>Pelaksanaan:</strong> {{ $masaPelaksanaan }}</p>

            @if (!empty($listPesanan) && is_array($listPesanan))
                <form method="GET" action="{{ route('preorder.print-selected', enkrip($data->id)) }}">
                    @csrf
                    <div class="overflow-auto rounded-lg border border-gray-200">
                        <table class="w-full table-fixed text-sm border border-gray-300">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    {{-- <th class="px-4 py-2 border border-gray-300 text-center w-10">
                                        <input type="checkbox" id="checkAll" class="form-checkbox">
                                    </th> --}}
                                    <th class="px-4 py-2 border border-gray-300 w-50">Nama</th>
                                    <th class="px-4 py-2 border border-gray-300 w-1/6">Volume</th>
                                    <th class="px-4 py-2 border border-gray-300 w-1/6">Satuan</th>
                                    <th class="px-4 py-2 border border-gray-300 w-1/6">Progress</th>
                                    <th class="px-4 py-2 border border-gray-300 w-1/6">Bobot</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($listPesanan as $index => $item)
                                    <tr class="hover:bg-gray-50">
                                        {{-- <td class="px-4 py-2 border border-gray-300 text-center">
                                            <input type="checkbox" name="selected[]" value="{{ $index }}" class="row-checkbox form-checkbox">
                                        </td> --}}
                                        <td class="px-4 py-2 border border-gray-300">{{ $item['nama'] ?? '-' }}</td>
                                        <td class="px-4 py-2 border border-gray-300">{{ $item['volume'] ?? '-' }}</td>
                                        <td class="px-4 py-2 border border-gray-300">{{ $item['satuan'] ?? '-' }}</td>
                                        <td class="px-4 py-2 border border-gray-300">{{ $item['progress'] ?? '-' }}</td>
                                        <td class="px-4 py-2 border border-gray-300">{{ $item['bobot'] ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- <div class="mt-4">
                        <button id="submitBtn" type="submit" class="btn btn-primary px-4 py-2" disabled>
                            Proses Preorder
                        </button>
                    </div> --}}
                </form>
            @else
                <p class="text-gray-500">Tidak ada data pesanan.</p>
            @endif

        </div>
    </div>
</x-app-layout>

<script>
    const checkAll = document.getElementById('checkAll');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    const submitBtn = document.getElementById('submitBtn');

    function updateSubmitButtonState() {
        const anyChecked = Array.from(rowCheckboxes).some(cb => cb.checked);
        submitBtn.disabled = !anyChecked;
    }

    // Trigger saat "Check All" diubah
    checkAll?.addEventListener('change', function () {
        rowCheckboxes.forEach(cb => cb.checked = this.checked);
        updateSubmitButtonState();
    });

    // Trigger saat checkbox individual diubah
    rowCheckboxes.forEach(cb => cb.addEventListener('change', updateSubmitButtonState));

    // Inisialisasi awal (jika ada yang pre-checked)
    updateSubmitButtonState();
</script>