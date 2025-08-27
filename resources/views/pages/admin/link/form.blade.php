@extends('layouts.layout-admin')

@section('content')
<div class="form-container">
    <div class="form-card">
        <div class="form-header">
            <h3 class="form-title text-white">{{ isset($detail) ? 'Ubah Link' : 'Tambah Link' }}</h3>
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
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="custom-link-checkbox" name="is_custom_link" {{ isset($detail) && $detail->is_custom ? 'checked' : '' }}>
                        <label class="form-check-label" for="custom-link-checkbox">
                            Gunakan Link Kustom
                        </label>
                    </div>
                </div>

                <div class="form-group" id="short-url-length-group">
                    <label for="link-length" class="form-label">Panjang Link</label>
                    <input type="number" id="link-length" name="short_url_length" class="form-input" placeholder="Misal: 6" value="6" min="2" max="15">
                    <small class="text-muted">Pilih panjang link antara 2 sampai 15 karakter.</small>
                </div>

                <div class="form-group" id="custom-link-group" style="display: none;">
                    <label for="custom-link" class="form-label">Link Kustom</label>
                    <input type="text" id="custom-link" name="custom_short_url" class="form-input" placeholder="Misal: link-saya">
                    <small class="text-muted">Gunakan karakter huruf, angka, dan tanda hubung (-). Panjang tidak terbatas.</small>
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

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkbox = document.getElementById('custom-link-checkbox');
            const lengthGroup = document.getElementById('short-url-length-group');
            const customGroup = document.getElementById('custom-link-group');

            function toggleInputs() {
                if (checkbox.checked) {
                    lengthGroup.style.display = 'none';
                    customGroup.style.display = 'block';
                } else {
                    lengthGroup.style.display = 'block';
                    customGroup.style.display = 'none';
                }
            }

            checkbox.addEventListener('change', toggleInputs);

            // Initial check on page load to set the correct state
            toggleInputs();
        });
    </script>
@endsection
