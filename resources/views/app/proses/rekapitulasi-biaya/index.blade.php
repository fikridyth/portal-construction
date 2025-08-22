@push('scripts')
    {{ $dataTable->scripts() }}
@endpush
<style>
    .file-upload {
        display: none; /* sembunyikan input asli */
    }

    .file-label {
        display: inline-block;
        padding: 8px 16px;
        background-color: #0d6efd;
        color: #fff;
        font-size: 14px;
        font-weight: 500;
        border-radius: 6px;
        cursor: pointer;
        margin-right: 10px;
        transition: 0.3s;
    }

    .file-label:hover {
        background-color: #0b5ed7;
    }

    .file-name {
        display: inline-block;
        font-size: 14px;
        padding: 6px 12px;
        border-radius: 6px;
        margin-right: 8px;
        background-color: #f1f3f4;
        color: #333;
        min-width: 150px;
        text-align: center;
    }
</style>
<x-app-layout :pageHeader="$pageHeader" :assets="$assets ?? []" :dir="false">
    <div class="mt-5">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">{{ $pageTitle ?? 'List' }}</h4>
                        </div>
                        <div class="card-action">
                            <form action="{{ route('upload-rekapitulasi-biaya') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" id="file" name="file" accept=".csv" class="file-upload">
                                <label for="file" class="file-label">Pilih File CSV</label>
                                <span id="file-name" class="file-name">Belum ada file</span>
                                <button type="submit" class="btn btn-success">Upload Data Rekapitulasi Biaya</button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body px-0">
                        <div class="table-responsive">
                            {{ $dataTable->table(['class' => 'table text-center table-striped w-100'], true) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const fileInput = document.getElementById('file');
        const fileName = document.getElementById('file-name');

        fileInput.addEventListener('change', function () {
            fileName.textContent = this.files.length > 0 ? this.files[0].name : 'Belum ada file';
        });
    </script>
</x-app-layout>
