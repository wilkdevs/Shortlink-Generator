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
    </style>

    <div class="row" style="min-height: 74vh">
        <div class="col-12 px-lg-4 px-0">
            <div class="card">
                <!-- Card header -->
                <div class="card-header pb-0">
                    <div class="d-lg-flex">
                        <div>
                            <h5 class="mb-0">Settings</h5>
                            <p class="text-sm mb-0">
                                Manage and edit here
                            </p>
                            @if (!isset($whatsapp))
                                <p class="bg-warning text-white px-3 py-1 mt-2 rounded-3">
                                    Catatan: Untuk mengubah gambar, sesuaikan dengan ukuran dan bingkai gambar default. Klik
                                    kanan pada gambar untuk menyimpan/mengunduh gambar terlebih dahulu, lalu edit dengan
                                    perangkat lunak/alat yang Anda sukai.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pb-0">
                    <div class="table-responsive">
                        <table class="table table-flush" id="products-list">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="">Title</th>
                                    <th class="">Value</th>
                                    <th class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                    $number = 0;
                                @endphp
                                @foreach ($list as $item)
                                    @if ($item['key'] != '')
                                        @php
                                            $number++;
                                        @endphp
                                        <tr>
                                            <td class="text-sm text-center">
                                                {{ $number }}
                                            </td>
                                            <td class="">
                                                {!! $item->title !!}
                                            </td>
                                            <td>
                                                @if ($item->type == 'image' && $item->value != '' && $item->value != null)
                                                    <img src="{{ $item->value }}" class="img img-fluid"
                                                        style="width: 150px;" />
                                                @elseif ($item->type == 'image' && $item->value == null && $item->default_value != null)
                                                    <img src="{{ $item->default_value }}" class="img img-fluid"
                                                        style="width: 150px;" />
                                                @elseif ($item->type == 'file' && $item->value != '' && $item->value != null)
                                                    <div style="width: 25vw" class="text-truncate">
                                                        <a href="{{ asset($item->value) }}"> <u>Download File</u> </a>
                                                    </div>
                                                @elseif ($item->type == 'file' && $item->value == null && $item->default_value != null)
                                                    <div style="width: 25vw" class="text-truncate">
                                                        <a href="{{ asset($item->default_value) }}"> <u>Download File</u> </a>
                                                    </div>
                                                @elseif ($item->type == 'boolean' && $item->value != '' && $item->value != null)
                                                    @if ($item->value == "TRUE")
                                                        Aktif
                                                    @else
                                                        Tidak Aktif
                                                    @endif
                                                @elseif ($item->type == 'boolean' && $item->value == null && $item->default_value != null)
                                                    @if ($item->default_value == "TRUE")
                                                        Aktif
                                                    @else
                                                        Tidak Aktif
                                                    @endif
                                                @elseif ($item->type == 'audio' && $item->value != '' && $item->value != null)
                                                    <audio controls>
                                                        <source src="{{ $item->value }}" type="audio/ogg">
                                                        <source src="{{ $item->value }}" type="audio/mpeg">
                                                        Your browser does not support the audio element.
                                                    </audio>
                                                @elseif ($item->type == 'audio' && $item->value == null && $item->default_value != null)
                                                    <audio controls>
                                                        <source src="{{ $item->default_value }}" type="audio/ogg">
                                                        <source src="{{ $item->default_value }}" type="audio/mpeg">
                                                        Your browser does not support the audio element.
                                                    </audio>
                                                @elseif ($item->type == 'color' && $item->value != '' && $item->value != null)
                                                    <input type="color" class="col-5" style="height: 20px"
                                                        value="{{ $item->value }}" disabled>
                                                @elseif ($item->type == 'gradientColor' && $item->value != '' && $item->value != null)
                                                    @foreach (json_decode($item->value) as $color)
                                                        <input type="color" class="col-5" style="height: 20px"
                                                            value="{{ $color }}" disabled>
                                                    @endforeach
                                                @elseif ($item->type == 'text' && ($item->value == '' || $item->value == null) && !str_contains($item->key, "whatsapp"))
                                                    <div style="width: 25vw" class="text-truncate">{!! $item->default_value !!}
                                                    </div>
                                                @elseif ($item->type == 'number' && ($item->value == '' || $item->value == null))
                                                    <div style="width: 25vw" class="text-truncate">{!! $item->default_value !!}
                                                    </div>
                                                @else
                                                    <div style="width: 25vw" class="text-truncate">{!! $item->value !!}</div>
                                                @endif
                                            </td>
                                            <td class="text-sm text-center">
                                                <a href="/admin/setting/view/{{ $item->key }}" class="mx-3"
                                                    data-bs-toggle="tooltip" data-bs-original-title="Ubah">
                                                    <i class="material-icons text-secondary position-relative text-lg">drive_file_rename_outline</i>
                                                </a>

                                                <a href="/admin/setting/view/reset/{{ $item->key }}" class="mx-3"
                                                    data-bs-toggle="tooltip" data-bs-original-title="Reset">
                                                    <i class="material-icons text-secondary position-relative text-lg">restart_alt</i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
