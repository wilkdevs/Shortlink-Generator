@extends('layouts.layout-admin')

@section('content')
    <div class="row" style="min-height: 74vh">
        <div class="col-lg-6 col-md-8 col-12 mx-auto px-lg-4 px-0">
            <h3 class="mt-3 mb-0 text-center">{{ isset($detail) ? 'Ubah' : 'Tambah' }} Hadiah</h3>
            <p class="lead font-weight-normal opacity-8 mb-5 text-center"></p>
            <div class="card z-index-0">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-primary border-radius-lg py-3 pe-1">
                        <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Form</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form role="form" id="form" class="text-start"
                        action="{{ isset($detail) ? '/admin/gift/update' : '/admin/gift/create' }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf

                        <p class="m-0 p-0 mt-3">Kategori</p>
                        <div class="input-group input-group-outline">
                            <select name="category_id" class="form-control">
                                <option value="">-- Pilih Kategori Hadiah --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ (isset($detail) && $detail->category_id == $category->id) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <p class="m-0 p-0 mt-3">Nama Hadiah</p>
                        <div class="input-group input-group-outline">
                            <input class="form-control" placeholder="Ketik Nama Hadiah"
                                value="{{ isset($detail) ? $detail->name : '' }}" name="name">
                        </div>

                        <p class="m-0 p-0 mt-3">Gambar Hadiah (Upload)</p>
                        <div class="input-group input-group-outline">
                            <input type="file" class="form-control" name="image" accept="image/*">
                        </div>

                        @if(isset($detail) && $detail->image)
                            <p class="small mt-2">Gambar Saat Ini:</p>
                            <img src="{{ asset($detail->image) }}" alt="Current Gift Image" style="max-height: 120px;">
                        @endif

                        <p class="m-0 p-0 mt-3">Persen Kemungkinan</p>
                        <div class="input-group input-group-outline">
                            <input class="form-control" type="number" placeholder="Ketik Persen Kemungkinan"
                                value="{{ isset($detail) ? $detail->probability : '100' }}" name="probability">
                        </div>

                        @if (isset($detail))
                            <input type="hidden" name="id" value="{{ $detail->id }}">
                        @endif

                        <div class="text-center mb-3">
                            <button type="submit" class="btn bg-gradient-success w-100 my-4 mb-2">
                                {{ isset($detail) ? 'Ubah' : 'Simpan' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
