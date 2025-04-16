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
        <h3 class="card-title">Shipments</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createShipmentModal">
            + Add Shipment
        </button>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Icon</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($shipments as $shipment)
                    <tr>
                        <td>{{ $shipment->name }}</td>
                        <td>{{ $shipment->code }}</td>
                        <td>
                            @if ($shipment->icon)
                                <img src="{{ asset('storage/icons/' . $shipment->icon) }}" width="32">
                            @endif
                        </td>
                        <td>{{ $shipment->description }}</td>
                        <td>
                            <span class="badge {{ $shipment->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $shipment->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                data-bs-target="#editShipmentModal{{ $shipment->id }}">Edit</button>
                            <form action="{{ route('shipments.destroy', $shipment->id) }}" method="POST"
                                style="display:inline-block;">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editShipmentModal{{ $shipment->id }}" tabindex="-1" aria-modal="true" role="dialog">
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <div class="modal-content rounded">
                                <!-- Modal Header -->
                                <div class="modal-header pb-0 border-0 justify-content-end">
                                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                    </div>
                                </div>

                                <!-- Modal Body -->
                                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                                    <form action="{{ route('shipments.update', $shipment->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <!-- Heading -->
                                        <div class="mb-13 text-center">
                                            <h1 class="mb-3">Edit Shipment</h1>
                                        </div>

                                        <!-- Form Content (Example Form) -->
                                        @include('shipments._form', ['shipment' => $shipment])

                                        <!-- Actions -->
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

<!-- Create Shipment Modal -->
<div class="modal fade" id="createShipmentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content rounded">
            <div class="modal-header pb-0 border-0 justify-content-end">
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                <form action="{{ url('shipments/store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-13 text-center">
                        <h1 class="mb-3">Create Shipment</h1>
                    </div>

                    @include('shipments._form')

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
