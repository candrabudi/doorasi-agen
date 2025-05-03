@extends('layouts.app')

@section('toolbar')
    <div id="kt_app_toolbar" class="app-toolbar  pt-7 pt-lg-10 ">
        <div id="kt_app_toolbar_container" class="app-container  container-fluid d-flex align-items-stretch ">
            <div class="d-flex flex-stack flex-row-fluid">
                <div class="d-flex flex-column flex-row-fluid">
                    <div class="page-title d-flex align-items-center gap-1 me-3">
                        <span class="text-gray-900 fw-bolder fs-2x lh-1">
                            Agen Doorasi
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
                                Data Agen
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
                        class="form-control form-control-solid w-250px ps-13" placeholder="Cari Agen: nama, kode">
                </div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <a href="{{ route('distributors.create') }}" class="btn btn-primary">
                        <i class="ki-duotone ki-plus fs-2"></i> Tambah Agen
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
                                <th class="min-w-125px">Tanggal Dibuat</th>
                                <th class="min-w-125px">Nama Agen</th>
                                <th class="min-w-125px">Kode Agen</th>
                                <th class="min-w-100px text-center">Status</th>
                                <th class="text-end min-w-150px">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="distributor-table-body" class="text-gray-600 fw-semibold">

                        </tbody>
                    </table>
                </div>
                <div id="pagination-container" class="row">
                    <div
                        class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start dt-toolbar">
                    </div>
                    <div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
                        <div class="dt-paging paging_simple_numbers">
                            <nav>
                                <ul class="pagination" id="pagination">
                                    
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tableBody = document.getElementById("distributor-table-body");
            const searchInput = document.querySelector('[data-kt-user-table-filter="search"]');
            const paginationContainer = document.getElementById("pagination");

            let currentPage = 1;

            function fetchDistributors(search = '', page = 1) {
                axios.get("{{ route('distributors.data') }}", {
                    params: {
                        search,
                        page
                    }
                }).then(response => {
                    const users = response.data.data;
                    const lastPage = response.data.last_page;

                    let html = '';
                    users.forEach(user => {
                        const status = user.status == 1 ? 'Active' : 'Inactive';
                        const checked = user.status == 1 ? 'checked' : '';
                        const distributor = user.distributor || {};

                        html += `
                    <tr>
                        <td>${new Date(user.created_at).toLocaleDateString()}</td>
                        <td>${distributor.full_name || '-'}</td>
                        <td>${distributor.agent_code || '-'}</td>
                        <td class="text-center">
                            <label class="form-switch form-switch-sm">
                                <input type="checkbox" class="form-check-input" ${checked}
                                    onchange="toggleStatus(${user.id}, this)">
                                <span class="form-check-label">${status}</span>
                            </label>
                        </td>
                        <td class="text-end">
                            <a href="/distributors/${user.id}/edit" class="btn btn-sm btn-light-primary me-2">
                                <i class="ki-duotone ki-pencil fs-5"></i> Edit
                            </a>
                            <form action="/distributors/${user.id}/destroy" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light-danger"
                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                    <i class="ki-duotone ki-trash fs-5"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                `;
                    });

                    tableBody.innerHTML = html;

                    handlePagination(lastPage);
                });
            }

            function handlePagination(lastPage) {
                let html = '';

                html += `<li class="dt-paging-button page-item ${currentPage == 1 ? 'disabled' : ''}">
                    <button class="page-link previous" type="button" aria-label="Previous" onclick="changePage(${currentPage - 1})">
                        <i class="previous"></i>
                    </button>
                  </li>`;

                for (let i = 1; i <= lastPage; i++) {
                    html += `<li class="dt-paging-button page-item ${currentPage == i ? 'active' : ''}">
                        <button class="page-link" type="button" onclick="changePage(${i})">${i}</button>
                      </li>`;
                }

                html += `<li class="dt-paging-button page-item ${currentPage == lastPage ? 'disabled' : ''}">
                    <button class="page-link next" type="button" aria-label="Next" onclick="changePage(${currentPage + 1})">
                        <i class="next"></i>
                    </button>
                  </li>`;

                paginationContainer.innerHTML = html;
            }

            window.changePage = function(page) {
                if (page < 1 || page > 10) return;
                currentPage = page;
                fetchDistributors(searchInput.value, currentPage);
            };

            searchInput.addEventListener("input", function() {
                fetchDistributors(this.value, 1);
            });

            fetchDistributors();
            window.toggleStatus = function(userId, checkbox) {
                const status = checkbox.checked ? 1 : 0;

                axios.patch(`/users/${userId}/status`, {
                    status
                }, {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(res => {
                    checkbox.nextElementSibling.textContent = status ? 'Active' : 'Inactive';
                }).catch(() => {
                    alert('Status update failed.');
                    checkbox.checked = !checkbox.checked;
                });
            };
        });
    </script>
@endsection
