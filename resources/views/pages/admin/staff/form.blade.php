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
                    <form role="form" class="text-start"
                        action="{{ isset($detailAdmin) ? '/admin/staff/update' : '/admin/staff/create' }}" method="POST"
                        novalidate="novalidate">
                        @csrf
                        <p class="m-0 p-0 mt-3">Nama</p>
                        <div class="input-group input-group-outline">
                            <input type="text" class="form-control" placeholder="Name" name="name"
                                value="{{ isset($detailUser) ? $detailUser->name : '' }}" required>
                        </div>
                        <p class="m-0 p-0 mt-3">Email</p>
                        <div class="input-group input-group-outline">
                            <input type="text" class="form-control" placeholder="Email" name="email"
                                value="{{ isset($detailUser) ? $detailUser->email : '' }}" required>
                        </div>
                        <p class="m-0 p-0 mt-3">Kata Sandi
                            {{ isset($detailAdmin) ? '(Leave blank if you do not want to change)' : '' }}</p>
                        <div class="input-group input-group-outline">
                            <input type="text" class="form-control" placeholder="Password" name="password" value=""
                                required>
                        </div>
                        <p class="m-0 p-0 mt-3">Hak Akses Halaman</p>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="invalidCheck1"
                                    name="access_rights_voucher" value="1"
                                    {{ isset($detailAccess) && $detailAccess->voucher == 1 ? 'checked' : (!isset($detailAccess) ? 'checked' : '') }}>
                                <label class="form-check-label" for="invalidCheck1">
                                    Daftar Voucher
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="invalidCheck1"
                                    name="access_rights_gift" value="1"
                                    {{ isset($detailAccess) && $detailAccess->gift == 1 ? 'checked' : (!isset($detailAccess) ? 'checked' : '') }}>
                                <label class="form-check-label" for="invalidCheck1">
                                    Daftar Hadiah
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="invalidCheck2"
                                    name="access_rights_settings" value="1"
                                    {{ isset($detailAccess) && $detailAccess->settings == 1 ? 'checked' : (!isset($detailAccess) ? 'checked' : '') }}>
                                <label class="form-check-label" for="invalidCheck2">
                                    Pengaturan
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="invalidCheck3"
                                    name="access_rights_admin_staff" value="1" value="1"
                                    {{ isset($detailAccess) && $detailAccess->admin_staff == 1 ? 'checked' : (!isset($detailAccess) ? 'checked' : '') }}>
                                <label class="form-check-label" for="invalidCheck3">
                                    Admin Staff
                                </label>
                            </div>
                        </div>
                        @if (isset($detailAdmin))
                            <input type="hidden" class="form-control" name="id" value="{{ $detailAdmin->id }}">
                        @endif
                        @if (isset($detailUser))
                            <input type="hidden" class="form-control" name="user_id" value="{{ $detailUser->id }}">
                        @endif
                        <div class="text-center mb-3">
                            <button type="submit" class="btn bg-gradient-success w-100 my-4 mb-2">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
