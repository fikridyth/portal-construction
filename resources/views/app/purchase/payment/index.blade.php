@push('scripts')
    {{ $dataTable->scripts() }}
@endpush
<x-app-layout :pageHeader="$pageHeader" :assets="$assets ?? []" :dir="false">
    <div class="mt-5">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title mt-3">{{ $pageTitle ?? 'List' }}</h4>
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
</x-app-layout>