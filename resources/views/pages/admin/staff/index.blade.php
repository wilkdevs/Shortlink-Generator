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
                            <h5 class="mb-0">Admin Staff</h5>
                            <p class="text-sm mb-0">
                                Manage, create new, delete, edit and review here
                            </p>
                        </div>
                        <div class="ms-auto my-auto mt-lg-0 mt-4">
                            <div class="ms-auto my-auto">
                                <a href="/admin/staff/new" class="btn bg-gradient-success btn-sm mb-0">+ Create New</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pb-0">
                    <div class="table-responsive">
                        <table class="table table-flush" id="products-list">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list as $item)
                                    <tr>
                                        <td class="text-sm">
                                            {{ $item->user_name }}
                                        </td>
                                        <td class="text-sm">
                                            {{ $item->user_email }}
                                        </td>
                                        <td class="text-sm">
                                            ***********
                                        </td>
                                        <td class="text-sm">
                                            <a href="/admin/staff/edit/{{ $item->id }}" class="mx-3"
                                                data-bs-toggle="tooltip" data-bs-original-title="Edit Staff">
                                                <i
                                                    class="material-icons text-secondary position-relative text-lg">drive_file_rename_outline</i>
                                            </a>
                                            <a href="/admin/staff/delete/{{ $item->id }}" class="mx-3"
                                                style="cursor: pointer" data-bs-toggle="tooltip"
                                                data-bs-original-title="Hapus Admin">
                                                <i class="material-icons text-danger position-relative text-lg">close</i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        if (document.getElementById('products-list')) {
            const dataTableSearch = new simpleDatatables.DataTable("#products-list", {
                searchable: true,
                fixedHeight: false,
                perPage: 7,
                columnDefs: [{
                    targets: 'no-sort',
                    orderable: false
                }]
            });
        };

        function copyLink(text) {

            var input = document.createElement("input");
            input.value = text.toUpperCase();

            input.select();
            input.setSelectionRange(0, 99999); /* For mobile devices */

            navigator.clipboard.writeText(input.value).then(function() {
                $.notify("Link telah di Copy. \n " + text.toUpperCase());
            }, function(err) {
                console.error('Async: Could not copy text: ', err);
            });
        }
    </script>
@endsection
