@extends('layouts.layout-admin')

@section('content')

    <div class="row" style="min-height: 74vh">
        <div class="col-lg-6 col-md-8 col-12 mx-auto px-lg-4 px-0">
            <h3 class="mt-3 mb-0 text-center">{{ $title }}</h3>
            <p class="lead font-weight-normal opacity-8 mb-5 text-center"></p>
            <div class="card z-index-0">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-primary border-radius-lg py-3 pe-1">
                        <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Form</h4>
                    </div>
                </div>

                <div class="card-body">
                    <form role="form" id="form" class="text-start" action="/admin/setting/view/save" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        @if (isset($detail))

                            @if ($detail->type == 'number')
                                <p class="m-0 p-0 mt-3">Silahkan masukkan angka</p>
                                <div class="input-group input-group-outline">
                                    <input type="number" class="form-control" name="value"
                                        value="{{ isset($detail) ? $detail->value : '' }}">
                                </div>
                            @endif

                            @if ($detail->type == 'text')
                                <p class="m-0 p-0 mt-3">Silahkan masukan teks</p>
                                <div class="input-group input-group-outline">
                                    <input type="text" class="form-control" name="value"
                                        value="{{ isset($detail) ? $detail->value : '' }}">
                                </div>
                            @endif

                            @if ($detail->type == 'size')
                                <p class="m-0 p-0 mt-3">Silahkan masukan lebar</p>
                                <div class="input-group input-group-outline">
                                    <input type="number" class="form-control" name="value1"
                                        value="{{ isset($detail) ? $detail->value[0] : '' }}">
                                </div>
                                <p class="m-0 p-0 mt-3">Silahkan masukan panjang</p>
                                <div class="input-group input-group-outline">
                                    <input type="numberDecimal" class="form-control" name="value2"
                                        value="{{ isset($detail) ? $detail->value[1] : '' }}">
                                </div>
                            @endif

                            @if ($detail->type == 'textarea')
                                <b class="m-0 p-0 mt-3">Silahkan masukan teks</b>
                                @if ($detail->key == 'alienTextWelcome')
                                    <p><u class="m-0 p-0 mt-3">Berikan 'enter' untuk memberikan jeda saat mengetik teks
                                            welcome selanjutnya dihalaman depan</u></p>
                                @endif
                                <div class="input-group input-group-outline">
                                    <textarea rows="6" class="form-control" name="value">{{ isset($detail) ? $detail->value : '' }}</textarea>
                                </div>
                            @endif

                            @if ($detail->type == 'widthSize')
                                <p class="m-0 p-0 mt-3 mb-1 font-weight-bold">Berikut adalah CSS (ukuran diurutkan dari kecil ke besar)</p>
                                <div class="input-group input-group-outline">
                                    <select class="form-control" name="value">
                                        <option value="w-0" {{ $detail->value == 'w-0' ? 'selected' : '' }}>w-0</option>
                                        <option value="w-px" {{ $detail->value == 'w-px' ? 'selected' : '' }}>w-px</option>
                                        <option value="w-0.5" {{ $detail->value == 'w-0.5' ? 'selected' : '' }}>w-0.5</option>
                                        <option value="w-1" {{ $detail->value == 'w-1' ? 'selected' : '' }}>w-1</option>
                                        <option value="w-1.5" {{ $detail->value == 'w-1.5' ? 'selected' : '' }}>w-1.5</option>
                                        <option value="w-2" {{ $detail->value == 'w-2' ? 'selected' : '' }}>w-2</option>
                                        <option value="w-2.5" {{ $detail->value == 'w-2.5' ? 'selected' : '' }}>w-2.5</option>
                                        <option value="w-3" {{ $detail->value == 'w-3' ? 'selected' : '' }}>w-3</option>
                                        <option value="w-3.5" {{ $detail->value == 'w-3.5' ? 'selected' : '' }}>w-3.5</option>
                                        <option value="w-4" {{ $detail->value == 'w-4' ? 'selected' : '' }}>w-4</option>
                                        <option value="w-5" {{ $detail->value == 'w-5' ? 'selected' : '' }}>w-5</option>
                                        <option value="w-6" {{ $detail->value == 'w-6' ? 'selected' : '' }}>w-6</option>
                                        <option value="w-7" {{ $detail->value == 'w-7' ? 'selected' : '' }}>w-7</option>
                                        <option value="w-8" {{ $detail->value == 'w-8' ? 'selected' : '' }}>w-8</option>
                                        <option value="w-9" {{ $detail->value == 'w-9' ? 'selected' : '' }}>w-9</option>
                                        <option value="w-10" {{ $detail->value == 'w-10' ? 'selected' : '' }}>w-10</option>
                                        <option value="w-11" {{ $detail->value == 'w-11' ? 'selected' : '' }}>w-11</option>
                                        <option value="w-12" {{ $detail->value == 'w-12' ? 'selected' : '' }}>w-12</option>
                                        <option value="w-13" {{ $detail->value == 'w-13' ? 'selected' : '' }}>w-13</option>
                                        <option value="w-14" {{ $detail->value == 'w-14' ? 'selected' : '' }}>w-14</option>
                                        <option value="w-16" {{ $detail->value == 'w-16' ? 'selected' : '' }}>w-16</option>
                                        <option value="w-20" {{ $detail->value == 'w-20' ? 'selected' : '' }}>w-20</option>
                                        <option value="w-24" {{ $detail->value == 'w-24' ? 'selected' : '' }}>w-24</option>
                                        <option value="w-28" {{ $detail->value == 'w-28' ? 'selected' : '' }}>w-28</option>
                                        <option value="w-32" {{ $detail->value == 'w-32' ? 'selected' : '' }}>w-32</option>
                                        <option value="w-36" {{ $detail->value == 'w-36' ? 'selected' : '' }}>w-36</option>
                                        <option value="w-40" {{ $detail->value == 'w-40' ? 'selected' : '' }}>w-40</option>
                                        <option value="w-44" {{ $detail->value == 'w-44' ? 'selected' : '' }}>w-44</option>
                                        <option value="w-48" {{ $detail->value == 'w-48' ? 'selected' : '' }}>w-48</option>
                                        <option value="w-52" {{ $detail->value == 'w-52' ? 'selected' : '' }}>w-52</option>
                                        <option value="w-56" {{ $detail->value == 'w-56' ? 'selected' : '' }}>w-56</option>
                                        <option value="w-60" {{ $detail->value == 'w-60' ? 'selected' : '' }}>w-60</option>
                                        <option value="w-64" {{ $detail->value == 'w-64' ? 'selected' : '' }}>w-64</option>
                                        <option value="w-72" {{ $detail->value == 'w-72' ? 'selected' : '' }}>w-72</option>
                                        <option value="w-80" {{ $detail->value == 'w-80' ? 'selected' : '' }}>w-80</option>
                                        <option value="w-96" {{ $detail->value == 'w-96' ? 'selected' : '' }}>w-96</option>
                                        <option value="w-auto" {{ $detail->value == 'w-auto' ? 'selected' : '' }}>w-auto</option>
                                        <option value="w-1/2" {{ $detail->value == 'w-1/2' ? 'selected' : '' }}>w-1/2</option>
                                        <option value="w-1/3" {{ $detail->value == 'w-1/3' ? 'selected' : '' }}>w-1/3</option>
                                        <option value="w-2/3" {{ $detail->value == 'w-2/3' ? 'selected' : '' }}>w-2/3</option>
                                        <option value="w-1/4" {{ $detail->value == 'w-1/4' ? 'selected' : '' }}>w-1/4</option>
                                        <option value="w-2/4" {{ $detail->value == 'w-2/4' ? 'selected' : '' }}>w-2/4</option>
                                        <option value="w-3/4" {{ $detail->value == 'w-3/4' ? 'selected' : '' }}>w-3/4</option>
                                        <option value="w-1/5" {{ $detail->value == 'w-1/5' ? 'selected' : '' }}>w-1/5</option>
                                        <option value="w-2/5" {{ $detail->value == 'w-2/5' ? 'selected' : '' }}>w-2/5</option>
                                        <option value="w-3/5" {{ $detail->value == 'w-3/5' ? 'selected' : '' }}>w-3/5</option>
                                        <option value="w-4/5" {{ $detail->value == 'w-4/5' ? 'selected' : '' }}>w-4/5</option>
                                        <option value="w-1/6" {{ $detail->value == 'w-1/6' ? 'selected' : '' }}>w-1/6</option>
                                        <option value="w-2/6" {{ $detail->value == 'w-2/6' ? 'selected' : '' }}>w-2/6</option>
                                        <option value="w-3/6" {{ $detail->value == 'w-3/6' ? 'selected' : '' }}>w-3/6</option>
                                        <option value="w-4/6" {{ $detail->value == 'w-4/6' ? 'selected' : '' }}>w-4/6</option>
                                        <option value="w-5/6" {{ $detail->value == 'w-5/6' ? 'selected' : '' }}>w-5/6</option>
                                        <option value="w-1/12" {{ $detail->value == 'w-1/12' ? 'selected' : '' }}>w-1/12</option>
                                        <option value="w-2/12" {{ $detail->value == 'w-2/12' ? 'selected' : '' }}>w-2/12</option>
                                        <option value="w-3/12" {{ $detail->value == 'w-3/12' ? 'selected' : '' }}>w-3/12</option>
                                        <option value="w-4/12" {{ $detail->value == 'w-4/12' ? 'selected' : '' }}>w-4/12</option>
                                        <option value="w-5/12" {{ $detail->value == 'w-5/12' ? 'selected' : '' }}>w-5/12</option>
                                        <option value="w-6/12" {{ $detail->value == 'w-6/12' ? 'selected' : '' }}>w-6/12</option>
                                        <option value="w-7/12" {{ $detail->value == 'w-7/12' ? 'selected' : '' }}>w-7/12</option>
                                        <option value="w-8/12" {{ $detail->value == 'w-8/12' ? 'selected' : '' }}>w-8/12</option>
                                        <option value="w-9/12" {{ $detail->value == 'w-9/12' ? 'selected' : '' }}>w-9/12</option>
                                        <option value="w-10/12" {{ $detail->value == 'w-10/12' ? 'selected' : '' }}>w-10/12</option>
                                        <option value="w-11/12" {{ $detail->value == 'w-11/12' ? 'selected' : '' }}>w-11/12</option>
                                        <option value="w-full" {{ $detail->value == 'w-full' ? 'selected' : '' }}>w-full</option>
                                        <option value="w-screen" {{ $detail->value == 'w-screen' ? 'selected' : '' }}>w-screen</option>
                                        <option value="w-svw" {{ $detail->value == 'w-svw' ? 'selected' : '' }}>w-svw</option>
                                        <option value="w-lvw" {{ $detail->value == 'w-lvw' ? 'selected' : '' }}>w-lvw</option>
                                        <option value="w-dvw" {{ $detail->value == 'w-dvw' ? 'selected' : '' }}>w-dvw</option>
                                        <option value="w-min" {{ $detail->value == 'w-min' ? 'selected' : '' }}>w-min</option>
                                        <option value="w-max" {{ $detail->value == 'w-max' ? 'selected' : '' }}>w-max</option>
                                        <option value="w-fit" {{ $detail->value == 'w-fit' ? 'selected' : '' }}>w-fit</option>
                                    </select>
                                </div>
                            @endif

                            @if ($detail->type == 'boolean')
                                <p class="m-0 p-0 mt-3">Silahkan centang untuk mengaktifkan</p>
                                <div class="input-group input-group-outline justify-content-center align-items-center mt-3">
                                    <input type="radio" name="value" style="width: 30px; height: 30px;" value="TRUE" @if ($detail->value == "TRUE") {{ "checked" }} @endif> <span style="margin-left: 10px;">Aktif</span>
                                    <input type="radio" name="value" style="width: 30px; height: 30px; margin-left: 30px" value="FALSE" @if ($detail->value == "FALSE" ||  isset($detail->value) == false) {{ "checked" }} @endif> <span style="margin-left: 10px;">Tidak Aktif</span>
                                </div>
                            @endif

                            @if ($detail->type == 'quill')
                                <input type="hidden" class="form-control" id="value" name="value"
                                    value="{{ isset($detail) ? $detail->value : '' }}">
                                <p class="m-0 p-0 mt-3">Please Enter Text</p>
                                <div id="edit-value" class="h-50">
                                    {!! isset($detail) ? $detail->value : '' !!}
                                </div>
                            @endif

                            @if ($detail->type == 'color')
                                <p class="m-0 p-0 mt-3">Please Select Color</p>
                                <div class="input-group input-group-outline">
                                    <input type="color" class="form-control" name="value"
                                        value="{{ isset($detail->value) ? $detail->value : $detail->default_value }}" style="height: 40px">
                                </div>
                            @endif

                            @if ($detail->type == 'gradientColor')
                                <?php $index = 0; ?>
                                @foreach (json_decode(isset($detail->value) ? $detail->value : $detail->default_value) as $color)
                                    <?php $index++; ?>
                                    <p class="m-0 p-0 mt-3">Please Select Color {{ $index }}</p>
                                    <div class="input-group input-group-outline">
                                        <input type="color" class="form-control" name="value[]"
                                            value="{{ $color }}" style="height: 40px">
                                    </div>
                                @endforeach
                            @endif

                            @if ($detail->type == 'image' || $detail->type == 'audio' || $detail->type == 'file')
                                <p class="m-0 p-0 mt-3">Select File</p>
                                <div class="input-group input-group-outline">
                                    <input type="file" class="form-control" name="value"
                                        value="{{ isset($detail) ? $detail->value : '' }}">
                                </div>
                            @endif

                            <p class="m-0 p-0 mt-3">Silahkan masukan Nama Pengaturan</p>
                            <div class="input-group input-group-outline">
                                <input type="text" class="form-control" name="title" value="{{ isset($detail) ? $detail->title : '' }}"
                                    placeholder="Nama Pengaturan">
                            </div>

                            @if (isset($detail))
                                <input type="hidden" class="form-control" name="key" value="{{ $detail->key }}">
                            @endif
                        @else
                            <p class="m-0 p-0 mt-3">Silahkan masukan ID</p>
                            <div class="input-group input-group-outline">
                                <input type="number" class="form-control" name="id" value=""
                                    placeholder="ID Setting">
                            </div>

                            <p class="m-0 p-0 mt-3">Silahkan masukan Key</p>
                            <div class="input-group input-group-outline">
                                <input type="text" class="form-control" name="key" value=""
                                    placeholder="Key Setting">
                            </div>

                            <p class="m-0 p-0 mt-3">Silahkan masukan Judul</p>
                            <div class="input-group input-group-outline">
                                <input type="text" class="form-control" name="title" value=""
                                    placeholder="Judul Setting">
                            </div>

                            <p class="m-0 p-0 mt-3">Silahkan masukan Default Value</p>
                            <div class="input-group input-group-outline">
                                <input type="text" class="form-control" name="default_value" value=""
                                    placeholder="Default Value Setting">
                            </div>

                            <p class="m-0 p-0 mt-3">Silahkan masukan Type</p>
                            <div class="input-group input-group-outline">
                                <input type="text" class="form-control" name="type" value=""
                                    placeholder="Type Setting">
                            </div>

                        @endif

                        <div class="text-center mb-3">
                            <button type="submit" class="btn bg-gradient-success w-100 my-4 mb-2">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        if (document.getElementById('edit-value')) {
            var quill = new Quill('#edit-value', {
                theme: 'snow' // Specify theme in configuration
            });
        };

        $("#form").on("submit", function() {
            $("#value").val($("#edit-value .ql-editor").html());
        })
    </script>
@endsection
