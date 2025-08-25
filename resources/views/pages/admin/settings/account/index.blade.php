@extends('layouts.layout-admin')

@section('content')
    <div class="row" style="min-height: 74vh">
        <div class="col-lg-6 col-md-8 col-12 mx-auto">
            <h3 class="mt-3 mb-0 text-center">Account</h3>
            <p class="lead font-weight-normal opacity-8 mb-5 text-center"></p>
            <div class="card z-index-0">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-primary border-radius-lg py-3 pe-1">
                        <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Form</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form role="form" action="/admin/setting/account/save" method="POST">
                        @csrf

                        <p class="m-0 p-0 mt-3">Email</p>
                        <div class="input-group input-group-outline">
                            <input type="text" class="form-control" placeholder="Email"
                                value="{{ isset($detail) ? $detail->email : '' }}" name="email" required>
                        </div>
                        <p class="m-0 p-0 mt-3">Password</p>
                        <div class="input-group input-group-outline">
                            <input type="text" class="form-control" placeholder="Password" value="" name="password"
                                required>
                        </div>
                        <div class="text-center mb-3">
                            <button type="submit" class="btn bg-gradient-success w-100 my-4 mb-2">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
