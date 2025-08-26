@extends('layouts.layout-admin')

@section('content')
    <div class="row min-vh-74">
        <div class="col-12 px-lg-4 px-0">
            <div class="card my-4">
                <!-- Card header -->
                <div class="card-header-custom">
                    <div class="d-lg-flex justify-content-lg-between align-items-center w-100">
                        <div>
                            <h5 class="mb-0">Daftar Link</h5>
                            <p class="text-sm mb-0">
                                Manage, create new, delete, and edit here
                            </p>
                        </div>
                        <div class="ms-auto my-auto mt-lg-0 mt-4 d-flex gap-2">
                            <a href="/admin/link/new" class="btn bg-gradient-success btn-sm mb-0">+ Tambah Link</a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pb-0">
                    <div class="table-responsive">
                        <table class="table table-flush" id="category-list">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center">Judul</th>
                                    <th class="text-center">Link Tujuan</th>
                                    <th class="text-center">Short Link</th>
                                    <th class="text-center">Pengunjung</th>
                                    <th class="text-center">Jumlah Klik</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center no-sort">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($list as $index => $item)
                                    <tr>
                                        <td class="text-center text-truncate" data-label="Judul">
                                            {{ $item['title'] }}
                                        </td>
                                        <td class="text-center max-width-cell md:text-truncate" data-label="Link Tujuan">
                                            {{-- Desktop view --}}
                                            <a href="{{ $item['long_url'] }}" target="_blank" class="table-link mobile-hide ">
                                                {{ $item['long_url'] }}
                                            </a>
                                            {{-- Mobile view --}}
                                            <a href="{{ $item['long_url'] }}" target="_blank" class="table-link mobile-show">
                                                View Link
                                                <i class="material-icons text-secondary position-relative text-lg" style="font-size: 1.25rem;">open_in_new</i>
                                            </a>
                                        </td>
                                        <td class="text-center" data-label="Short Link">
                                            <a href="{{ url($item['short_url']) }}" target="_blank" class="table-link">
                                                {{ url($item['short_url']) }}
                                            </a>
                                        </td>
                                        <td class="text-center" data-label="Pengunjung">
                                            <a href="{{ url('admin/link/' . $item->short_url . '/visitors') }}" class="table-link visitor-cell">
                                                <span style="margin-right: 8px;">{{ $item->visitors_count ?? 0 }}</span>
                                                <i class="material-icons text-secondary position-relative text-lg">visibility</i>
                                            </a>
                                        </td>
                                        <td class="text-center text-truncate" data-label="Jumlah Klik">
                                            {{ $item['clicks_count'] }}
                                        </td>
                                        <td class="text-center" data-label="Status">
                                            <input onclick="onChangeStatus('{{ $item->id }}')" type="checkbox" @if ($item->status == 1) checked @endif />
                                        </td>
                                        <td class="text-sm text-center" data-label="Aksi">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <a href="/admin/link/edit/{{ $item->id }}" data-bs-toggle="tooltip" data-bs-original-title="Ubah Link">
                                                    <i class="material-icons text-secondary position-relative text-lg">drive_file_rename_outline</i>
                                                </a>
                                                <a href="/admin/link/delete/{{ $item->id }}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Hapus Link">
                                                    <i class="material-icons text-secondary position-relative text-lg">delete</i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center text-muted" colspan="7">
                                            Tidak ada data link.
                                        </td>
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
        function onChangeStatus(id) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const url = '/admin/link/status'
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
