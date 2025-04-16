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
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span class="path1"></span><span
                            class="path2"></span></i> <input type="text" data-kt-user-table-filter="search"
                        class="form-control form-control-solid w-250px ps-13" placeholder="Search user">
                </div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <a href="{{ route('users.create') }}" class="btn btn-primary">
                        <i class="ki-duotone ki-plus fs-2"></i> Add User
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body py-4">
            <div id="kt_table_users_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
                <div id="" class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable" id="kt_table_users">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase">
                                <th class="min-w-125px">Username</th>
                                <th class="min-w-125px">Email</th>
                                <th class="min-w-125px">Phone Number</th>
                                <th class="min-w-125px">Created At</th>
                                <th class="min-w-125px">Updated At</th>
                                <th class="min-w-100px text-center">Status</th>
                                <th class="text-end min-w-150px">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-semibold">
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone_number }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>{{ $user->updated_at }}</td>
                                    <td class="text-center">
                                        <label class="form-switch form-switch-sm">
                                            <input type="checkbox" class="form-check-input"
                                                {{ $user->status == 1 ? 'checked' : '' }}
                                                onchange="toggleStatus({{ $user->id }})">
                                            <span class="form-check-label">
                                                {{ $user->status == 1 ? 'Active' : 'Inactive' }}
                                            </span>
                                        </label>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-light-primary me-2">
                                            <i class="ki-duotone ki-pencil fs-5"></i> Edit
                                        </a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light-danger"
                                                onclick="return confirm('Are you sure you want to delete this user?')">
                                                <i class="ki-duotone ki-trash fs-5"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    

                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleStatus(userId) {
            const checkbox = event.target;
            const status = checkbox.checked ? 1 : 0;
    
            fetch(`/users/${userId}/status`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ status: status })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    alert(data.message);
                    checkbox.checked = !checkbox.checked; // rollback on fail
                }
            })
            .catch(error => {
                alert('Error updating status.');
                checkbox.checked = !checkbox.checked; // rollback on fail
            });
        }
    </script>
    
@endsection
