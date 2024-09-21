<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <!-- endinject -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script> --}}
</head>

<style>
    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
        transition: opacity 0.3s ease;
    }

    .modal-content {
        background-color: #fff;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        border-radius: 5px;
        width: 80%;
        max-width: 500px;
        position: relative;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .close {
        background-color: red;
        color: #fff;
        border: none;
        border-radius: 10%;
        padding: 0.5rem;
        font-size: 1.5rem;
        cursor: pointer;
        position: absolute;
        top: 5px;
        right: 10px;
        transition: background-color 0.3s ease;
    }

    .close:hover {
        background-color: darkred;
    }

    .modal-body {
        padding: 20px;
    }
</style>

<script>
    // Show Modal
    function showModal(id) {
        var modal = document.getElementById(id);
        if (modal) {
            modal.style.display = "block";
        }
    }

    // Close Modal
    function closeModal(id) {
        var modal = document.getElementById(id);
        if (modal) {
            modal.style.display = "none";
        }
    }

    // Close modals when clicking outside of them
    window.onclick = function(event) {
        var modals = document.querySelectorAll('.modal');
        modals.forEach(function(modal) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        });
    }
</script>

<body>
    <div class="container-scroller">

        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item nav-profile border-bottom">
                    <a href="#" class="nav-link flex-column">
                        <div class="nav-profile-image">
                            <img src="{{ asset('assets/images/logo.png') }}" alt="profile">
                        </div>
                        <div class="nav-profile-text d-flex ms-0 mb-3 flex-column">
                            <span class="fw-semibold mb-1 mt-2 text-center">{{ auth()->user()->name }}</span>
                            <span class="text-secondary icon-sm text-center">{{ auth()->user()->email }}</span>
                        </div>
                    </a>
                </li>

                <li class="pt-2 pb-1">
                    <span class="nav-item-head">Template Pages</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/dashboard">
                        <i class="mdi mdi-compass-outline menu-icon"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/admin/suara">
                        <i class="mdi mdi-ballot menu-icon"></i>
                        <span class="menu-title">Rekapitulasi Suara</span>
                    </a>
                </li>

                @if (auth()->user()->role == 'superadmin' || auth()->user()->role == 'admin')
                    <li class="pt-2 pb-1">
                        <span class="nav-item-head">Olah Data</span>
                    </li>
                    {{-- Menu yang bisa diakses oleh admin dan superadmin --}}
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/kecamatan">
                            <i class="mdi mdi-map-marker menu-icon"></i>
                            <span class="menu-title">Kecamatan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/kelurahan">
                            <i class="mdi mdi-map menu-icon"></i>
                            <span class="menu-title">Kelurahan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/tps">
                            <i class="mdi mdi-map-marker menu-icon"></i>
                            <span class="menu-title">TPS</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/calon">
                            <i class="mdi mdi-account-group menu-icon"></i>
                            <span class="menu-title">Pasangan Calon</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->role == 'superadmin')
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/users">
                            <i class="mdi mdi-account menu-icon"></i>
                            <span class="menu-title">Users</span>
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-logout menu-icon"></i>
                        <span class="menu-title">Logout</span>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </a>
                </li>
            </ul>
        </nav>



        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_navbar.html -->
            <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
                <div class="navbar-menu-wrapper d-flex align-items-stretch">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button"
                        data-toggle="minimize">
                        <span class="mdi mdi-chevron-double-left"></span>
                    </button>
                    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                        <a class="navbar-brand brand-logo-mini" href="/admin/dashboard"><img
                                src="../../../assets/images/logo-mini.svg" alt="logo" /></a>
                    </div>

                    <ul class="navbar-nav navbar-nav-right">


                        <li class="nav-item nav-profile dropdown d-none d-md-block">
                            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="nav-profile-img">
                                    <!-- Display user's profile photo -->
                                    <img src="{{ asset('assets/images/logo.png') }}" alt="Profile Photo"
                                        class="rounded-circle" />
                                </div>
                                <div class="nav-profile-text">
                                    <!-- Display user's name -->
                                    <span class="fw-semibold">{{ auth()->user()->name }}</span>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                                aria-labelledby="profileDropdown">

                                <a class="dropdown-item" href="#" onclick="showModal('changePasswordModal')">
                                    <i class="mdi mdi-lock me-3"></i> Account
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="mdi mdi-logout me-3"></i> Logout
                                </a>
                                <!-- Logout form -->
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                            <!-- Change Password Modal -->


                        </li>


                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                        data-toggle="offcanvas">
                        <span class="mdi mdi-menu"></span>
                    </button>
                </div>
            </nav>
            </nav>

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                </div>
                <!-- content-wrapper ends -->
                <!-- footer -->
                <br>

                <footer class="footer" style="background-color: brown">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-center text-sm-left d-block d-sm-inline-block"
                            style="color: white;">Copyright © 2023
                            <a href="#" target="_blank" style="color: white;">Real Count PDIP</a>. All rights
                            reserved.
                        </span>
                        <span class="float-none float-sm-end d-block mt-1 mt-sm-0 text-center"
                            style="color: white;">Tapaleuk Programmer
                            <i class="mdi mdi-heart text-danger"></i>
                        </span>
                    </div>
                </footer>

                <!-- footer ends -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- Change Password Modal -->
    <div class="modal" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                    <button type="button" class="close"
                        onclick="closeModal('changePasswordModal')">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="change-password-form" method="POST" action="{{ route('change.password') }}">
                        @csrf
                        <div class="mb-3">
                            <input readonly type="text" value="{{ auth()->user()->name }}" class="form-control"
                                name="name" required>
                        </div>
                        <div class="mb-3">
                            <input readonly type="text" value="{{ auth()->user()->email }}" class="form-control"
                                name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current_password"
                                name="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="new_password_confirmation"
                                name="new_password_confirmation" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check for success and error session messages
            @if (session('status'))
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('status') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            @elseif (session('error'))
                Swal.fire({
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonText: 'Try Again'
                });
            @endif

            // Check for validation errors
            @if ($errors->any())
                Swal.fire({
                    title: 'Error!',
                    text: '{{ $errors->first() }}',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- plugins:js -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    {{-- ini --}}
    {{-- <script src="{{ asset('assets/vendors/js/vendor.bundle.addons.js') }}"></script> --}}
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/js/misc.js') }}"></script>
    <script src="{{ asset('assets/js/settings.js') }}"></script>
    <script src="{{ asset('assets/js/todolist.js') }}"></script>
    <!-- endinject -->

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script>
        $(document).ready(function() {
            $('#exampleTable').DataTable({
                "paging": true, // Mengaktifkan pagination
                "searching": true, // Mengaktifkan fitur pencarian
                "info": true, // Menampilkan informasi jumlah data
                "autoWidth": false, // Mencegah otomatis penyesuaian lebar kolom
                "order": [ // Urutkan berdasarkan kolom pertama (nomor urut)
                    [0, 'asc']
                ],
                "columnDefs": [{
                    "targets": 0, // Targetkan kolom pertama (nomor urut)
                    "orderable": true, // Mengaktifkan sorting
                    "type": 'num' // Pastikan sorting numerik
                }]
            });
        });
    </script>



</body>

</html>
