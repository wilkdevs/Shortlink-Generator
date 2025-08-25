@extends('layouts.layout-admin')

@section('content')
    <style>
        .no-sort::after {
            display: none !important;
        }

        .no-sort {
            pointer-events: none !important;
            cursor: default !important;
        }
        td, th {
            vertical-align: middle !important;
        }

        .pagination .page-link {
            border-radius: 6px;
            margin: 0 2px;
            color: #5e72e4;
            transition: all 0.2s ease;
        }

        .pagination .page-item.active .page-link {
            background-color: #5e72e4;
            border-color: #5e72e4;
            color: #fff;
        }

        .pagination .page-link:hover {
            background-color: #d4d9ff;
        }
    </style>

    <div class="row" style="min-height: 74vh">
        <div class="col-12 px-lg-4 px-0">
            <div class="card">
                <!-- Card header -->
                <div class="card-header pb-0">
                    <div class="d-lg-flex flex-column flex-lg-row">
                        <div>
                            <h5 class="mb-0">Daftar Hadiah</h5>
                            <p class="text-sm mb-0">
                                Manage, create new, delete, and edit here
                            </p>
                        </div>

                        <div class="ms-lg-auto mt-3 mt-lg-0 d-flex flex-column align-items-lg-end gap-2">
                            <div class="d-flex gap-2">
                                <a href="/admin/gift/new" class="btn bg-gradient-success btn-sm mb-0">+ Tambah Hadiah</a>
                            </div>

                            {{-- Category filter --}}
                            <form method="GET">
                                <select name="category_id" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="">Semua Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $selectedCategory == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body px-0 pb-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Gambar</th>
                                    <th class="text-center">Nama Hadiah</th>
                                    <th class="text-center">Kategori</th>
                                    <th class="text-center">Persen Kemungkinan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($list as $index => $item)
                                    <tr class="gift-row" data-name="{{ strtolower($item->name) }}"  data-id="{{ strtolower($item->id) }}">
                                        <td class="text-center">{{ $list->firstItem() + $index }}</td>

                                        <td class="text-center">
                                            <img src="{{ asset($item->image) }}" alt="{{ $item->name }}"
                                                class="rounded" width="50" height="50" style="object-fit: cover;">
                                        </td>

                                        <td class="text-center text-truncate" style="max-width: 120px;" title="{{ $item->name }}">
                                            {{ $item->name }}
                                        </td>

                                        <td class="text-center">{{ $item->category->name ?? '-' }}</td>

                                        <td class="text-center">
                                            <span class="badge percent-success">
                                                {{ $item->probability ?? '0' }}%
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="/admin/gift/edit/{{ $item->id }}" class="text-primary"
                                                data-bs-toggle="tooltip" title="Ubah Hadiah">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                                <a href="/admin/gift/delete/{{ $item->id }}" class="text-danger"
                                                onclick="return confirm('Yakin ingin menghapus hadiah ini?')"
                                                data-bs-toggle="tooltip" title="Hapus Hadiah">
                                                    <i class="material-icons">delete</i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center text-muted" colspan="8">Tidak ada data hadiah.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="mt-4 d-flex justify-content-center">
                            {{ $list->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var server_settings = {!! json_encode($settings) !!};

        function onChangeStatus(id) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const url = '/admin/gift/status'
            const data = {
                id: id
            };

            const xhr = new XMLHttpRequest();
            xhr.open('POST', url);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhr.onload = function () {
                if (xhr.status === 200) {

                } else {
                    alert('Request failed. Returned status of ' + xhr.status);
                }
            };
            xhr.send(JSON.stringify(data));
        }
    </script>

@endsection
