<!doctype html>
<html lang="en">
    <head>
        @include('includes.meta')
        <title>Dashboard - Tabler - Premium and Open Source dashboard template with responsive and high quality UI.</title>
        <!-- CSS files -->
        @include('includes.style')
        @stack('after-style')
        <style>
        @import url('https://rsms.me/inter/inter.css');
        :root {
        --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }
        body {
        font-feature-settings: "cv03", "cv04", "cv11";
        }
        </style>
    </head>
    <body>
        @routes()
        <script src="{{ asset ('') }}assets/dist/js/demo-theme.min.js?1685973381"></script>
        <div class="page">
            <!-- Sidebar -->
            @include('includes.sidebar')
            <!-- Navbar -->
            @include('includes.navbar')
            <div class="page-wrapper">
            <!-- Page header -->
                <div class="page-header d-print-none">
                    <div class="container-xl">
                        <div class="row g-2 align-items-center">
                            <div class="col">
                            <!-- Page pre-title -->
                                <div class="page-pretitle">
                                {{ $pretitle ?? ''}}
                                </div>
                                <h2 class="page-title">
                                {{ $title ?? ''}}
                                </h2>
                            </div>
                            <!-- Page title actions -->
                            <div class="col-auto ms-auto d-print-none">
                                <div class="btn-list">
                                <span class="d-none d-sm-inline">
                                @stack('page-export')
                                </span>
                                @stack('page-action')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Page body -->
                <div class="page-body">
                    <div class="container-xl">
                    @yield('content')
                    </div>
                </div>
                <!-- Footer -->
                @include('includes.footer')
            </div>
        </div>
        <!-- Libs JS -->
        @include('includes.script')
        @stack('after-script')
        @include('sweetalert::alert')
    </body>
</html>
