<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="shortcut icon" href="{{ asset('/assets/images/logo.png') }}" />
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .background-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('assets/images/background.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: -1;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            z-index: -1;
        }

        .auth-form-light {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            padding: 4rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 90%;
            /* Adjust for smaller screens */
            max-width: 400px;
            text-align: center;
        }

        .auth-form-light .brand-logo img {
            max-width: 150px;
            margin-bottom: 1rem;
        }

        .auth-form-light h1 {
            margin-bottom: 0.5rem;
            font-size: 1.5rem;
            color: #333;
        }

        .auth-form-light .form-group {
            margin-bottom: 1rem;
        }

        .auth-form-light .form-control {
            border-radius: 4px;
            border: 1px solid #ddd;
            padding: 0.75rem;
            font-size: 1rem;
            width: 100%;
        }

        .auth-form-light .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
            padding: 0.75rem;
            border-radius: 4px;
            font-size: 1rem;
        }

        .auth-form-light .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        @media (max-width: 768px) {
            .auth-form-light {
                padding: 3rem;
            }

            .auth-form-light h1 {
                font-size: 1.25rem;
            }

            .auth-form-light .form-control {
                font-size: 0.9rem;
            }

            .auth-form-light .btn-primary {
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    <div class="background-image"></div>
    <div class="overlay"></div>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row flex-grow">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5">
                            <div class="brand-logo">
                                <img src="{{ asset('../assets/images/logo.png') }}" alt="Logo">
                            </div>
                            <h1 class="fw-light">Login</h1>
                            <form class="login-form pt-3" method="POST" action="{{ route('login.post') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-control-lg"
                                        placeholder="Email" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-control-lg"
                                        id="password" placeholder="Password" required>
                                </div>
                                <div class="form-group" style="margin-top: 0px">
                                    <input type="checkbox" id="show-password"> Show Password
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="submit"
                                        class="btn btn-block btn-primary btn-lg fw-semibold auth-form-btn">LOGIN</button>
                                </div>
                                <div class="my-2 d-flex justify-content-between align-items-center"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <script>
        document.getElementById('show-password').addEventListener('change', function() {
            let passwordInput = document.getElementById('password');
            passwordInput.type = this.checked ? 'text' : 'password';
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/misc.js') }}"></script>
    <script src="{{ asset('assets/js/settings.js') }}"></script>
    <script src="{{ asset('assets/js/todolist.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
</body>

</html>
