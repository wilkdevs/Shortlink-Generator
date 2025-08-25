@extends('layouts.layout-admin')

@section('content')
<div class="form-container">
    <div class="form-card">
        <div class="form-header">
            <h3 class="form-title">{{ isset($detail) ? 'Ubah Link' : 'Tambah Link' }}</h3>
        </div>
        <div class="form-body">
            <form role="form" id="form" class="form"
                  action="{{ isset($detail) ? '/admin/link/update' : '/admin/link/create' }}"
                  method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="title" class="form-label">Judul Link</label>
                    <input type="text" id="title" name="title" class="form-input" placeholder="Ketik Judul Link"
                           value="{{ isset($detail) ? $detail->title : '' }}">
                </div>

                <div class="form-group">
                    <label for="long-link" class="form-label">Link Tujuan</label>
                    <input type="text" id="long-link" name="long_url" class="form-input" placeholder="Ketik Link Tujuan"
                           value="{{ isset($detail) ? $detail->long_url : '' }}">
                </div>

                @if (isset($detail))
                    <div class="form-group">
                        <label for="short-link" class="form-label">Short Link</label>
                        <input type="text" id="short-link" disabled name="short_url" class="form-input" value="{{ $detail->short_url }}">
                        <input type="hidden" name="id" value="{{ $detail->id }}">
                    </div>
                @endif

                <div class="form-group">
                    <label for="link-length" class="form-label">Panjang Link</label>
                    <input type="number" id="link-length" name="short_url_length" class="form-input" placeholder="Misal: 6" value="6" min="2" max="15">
                    <small class="text-muted">Pilih panjang link antara 2 sampai 15 karakter.</small>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-submit">
                        {{ isset($detail) ? 'Ubah' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
