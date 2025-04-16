<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ceres HTML Pro - Bootstrap 5 HTML Multipurpose Admin Dashboard Theme</title>
    <meta charset="utf-8" />
    <meta name="description" content="Ceres admin dashboard live demo. Check out all the features of the admin panel." />
    <meta name="keywords"
        content="Ceres theme, bootstrap, bootstrap 5, admin themes, free admin themes, bootstrap admin, bootstrap dashboard" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Ceres HTML Pro - Bootstrap 5 HTML Multipurpose Admin Dashboard Theme" />
    <meta property="og:url" content="https://keenthemes.com/products/ceres-html-pro" />
    <meta property="og:site_name" content="Ceres HTML Pro by Keenthemes" />
    <link rel="canonical" href="basic.html" />
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-37564768-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-37564768-1');
    </script>
    <script>
        if (window.top != window.self) {
            window.top.location.replace(window.self.location.href);
        }
    </script>
</head>

<body id="kt_body" class="auth-bg">
    <script>
        var defaultThemeMode = "light";
        var themeMode;

        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }

            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }

            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5FS8GGP" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>

    <div class="d-flex flex-column flex-root">
        <style>
            .auth-page-bg {
                background-image: url('{{ asset('assets/media/illustrations/dozzy-1/14.png') }}');
            }

            [data-bs-theme="dark"] .auth-page-bg {
                background-image: url('{{ asset('assets/media/illustrations/dozzy-1/14-dark.png') }}');
            }
        </style>

        <div
            class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed auth-page-bg">
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                <a href="{{ asset('index.html') }}" class="mb-12">
                    <img alt="Logo" src="{{ asset('assets/media/logos/logo.png') }}"
                        class="h-30px theme-light-show" />
                    <img alt="Logo" src="{{ asset('assets/media/logos/logo.png') }}"
                        class="h-30px theme-dark-show" />
                </a>
                <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                    <form class="form w-100" method="POST" action="{{ route('login.process') }}" id="kt_sign_in_form">
                        @csrf
                        <div class="text-center mb-10">
                            <h1 class="text-gray-900 mb-3">Sign In Doorasi</h1>
                        </div>

                        <div class="fv-row mb-10">
                            <label class="form-label fs-6 fw-bold text-gray-900">Username or Email</label>
                            <input class="form-control form-control-lg form-control-solid" type="text" name="login"
                                autocomplete="off" />
                        </div>

                        <div class="fv-row mb-10">
                            <div class="d-flex flex-stack mb-2">
                                <label class="form-label fw-bold text-gray-900 fs-6 mb-0">Password</label>
                                {{-- <a href="{{ asset('authentication/password-reset.html') }}"
                                    class="link-primary fs-6 fw-bold">
                                    Forgot Password ?
                                </a> --}}
                            </div>
                            <input class="form-control form-control-lg form-control-solid" type="password"
                                name="password" autocomplete="off" />
                        </div>

                        <div class="text-center">
                            <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                                <span class="indicator-label">Continue</span>
                                <span class="indicator-progress">
                                    Please wait... <span
                                        class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        var hostUrl = "{{ asset('assets/index.html') }}";
    </script>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/custom/authentication/sign-in/general.js') }}"></script> --}}
</body>

</html>
