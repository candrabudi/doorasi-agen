@extends('layouts.app')

@section('toolbar')
    <div id="kt_app_toolbar" class="app-toolbar  pt-7 pt-lg-10 ">
        <div id="kt_app_toolbar_container" class="app-container  container-fluid d-flex align-items-stretch ">
            <div class="d-flex flex-stack flex-row-fluid">
                <div class="d-flex flex-column flex-row-fluid">
                    <div class="page-title d-flex align-items-center gap-1 me-3">
                        <span class="text-gray-900 fw-bolder fs-2x lh-1">
                            Users
                        </span>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-base ms-3 d-flex mb-0">
                            <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                                <a href="index-2.html" class="text-gray-700 text-hover-primary">
                                    <i class="ki-duotone ki-home fs-3 text-gray-500 ms-2"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item mx-n1">
                                <i class="ki-duotone ki-right fs-4 text-gray-700"></i>
                            </li>
                            <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                                User List
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Marketplaces</h3>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createMarketPlaceModal">
                + Add Marketplace
            </button>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Icon</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($marketPlaces as $marketPlace)
                        <tr>
                            <td>{{ $marketPlace->name }}</td>
                            <td>
                                @if ($marketPlace->icon)
                                    <img src="{{ asset('storage/icons/' . $marketPlace->icon) }}" width="32">
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#editMarketPlaceModal{{ $marketPlace->id }}">Edit</button>
                                <form action="{{ route('marketplaces.destroy', $marketPlace->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editMarketPlaceModal{{ $marketPlace->id }}" tabindex="-1"
                            aria-modal="true" role="dialog">
                            <div class="modal-dialog modal-dialog-centered mw-650px">
                                <div class="modal-content rounded">
                                    <!-- Modal Header -->
                                    <div class="modal-header pb-0 border-0 justify-content-end">
                                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                                    class="path2"></span></i>
                                        </div>
                                    </div>

                                    <!-- Modal Body -->
                                    <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                                        <form action="{{ route('marketplaces.update', $marketPlace->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <!-- Heading -->
                                            <div class="mb-13 text-center">
                                                <h1 class="mb-3">Edit Marketplace</h1>
                                            </div>

                                            <!-- Form Content -->
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" name="name" id="name" class="form-control"
                                                    value="{{ $marketPlace->name }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="icon" class="form-label">Icon</label>
                                                <input type="file" name="icon" id="icon" class="form-control">
                                                <small>Leave blank if you don't want to change the icon.</small>
                                            </div>

                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">
                                                    Update
                                                </button>
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                    Cancel
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- End Modal Body -->
                                </div>
                            </div>
                        </div>
                        <!-- End Edit Modal -->
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create Marketplace Modal -->
    <div class="modal fade" id="createMarketPlaceModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content rounded">
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                    <form action="{{ route('marketplaces.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-13 text-center">
                            <h1 class="mb-3">Create Marketplace</h1>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="icon" class="form-label">Icon</label>
                            <input type="file" name="icon" id="icon" class="form-control" required>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">
                                Save
                            </button>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
