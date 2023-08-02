
<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta19
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Sign in - Tabler - Premium and Open Source dashboard template with responsive and high quality UI.</title>
    <meta name="msapplication-TileColor" content=""/>
    <meta name="theme-color" content=""/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="mobile-web-app-capable" content="yes"/>
    <meta name="HandheldFriendly" content="True"/>
    <meta name="MobileOptimized" content="320"/>
    <link rel="icon" href="{{ asset ('') }}assets/favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="{{ asset ('') }}assets/favicon.ico" type="image/x-icon"/>
    <meta name="description" content="Tabler comes with tons of well-designed components and features. Start your adventure with Tabler and make your dashboard great again. For free!"/>
    <meta name="canonical" content="https://preview.tabler.io/sign-in.html">
    <meta name="twitter:image:src" content="https://preview.tabler.io/static/og.png">
    <meta name="twitter:site" content="@tabler_ui">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Tabler: Premium and Open Source dashboard template with responsive and high quality UI.">
    <meta name="twitter:description" content="Tabler comes with tons of well-designed components and features. Start your adventure with Tabler and make your dashboard great again. For free!">
    <meta property="og:image" content="https://preview.tabler.io/static/og.png">
    <meta property="og:image:width" content="1280">
    <meta property="og:image:height" content="640">
    <meta property="og:site_name" content="Tabler">
    <meta property="og:type" content="object">
    <meta property="og:title" content="Tabler: Premium and Open Source dashboard template with responsive and high quality UI.">
    <meta property="og:url" content="https://preview.tabler.io/static/og.png">
    <meta property="og:description" content="Tabler comes with tons of well-designed components and features. Start your adventure with Tabler and make your dashboard great again. For free!">
    <!-- CSS files -->
    <link href="{{ asset ('') }}assets/dist/css/tabler.min.css?1685973381" rel="stylesheet"/>
    <link href="{{ asset ('') }}assets/dist/css/tabler-flags.min.css?1685973381" rel="stylesheet"/>
    <link href="{{ asset ('') }}assets/dist/css/tabler-payments.min.css?1685973381" rel="stylesheet"/>
    <link href="{{ asset ('') }}assets/dist/css/tabler-vendors.min.css?1685973381" rel="stylesheet"/>
    <link href="{{ asset ('') }}assets/dist/css/demo.min.css?1685973381" rel="stylesheet"/>
    <style>
    @import url('https://rsms.me/inter/inter.css');
    :root {
        --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
    }
    body {
        background-image: url('{{ asset ('') }}assets/logo/background-login.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        font-feature-settings: "cv03", "cv04", "cv11";
    }
    .logo-image {
    width: 200px;
    height: auto;
    }
    </style>
</head>
<body  class=" d-flex flex-column">
    <script src="{{ asset ('') }}assets/dist/js/demo-theme.min.js?1685973381"></script>
    <div class="page page-center">
    <div class="container container-tight py-4">
        <div class="text-center mb-4">
        <a href="." class="navbar-brand navbar-brand-autodark">
            <img src="{{ asset('assets/logo/cmnplogo.png') }}" alt="Logo" class="mb-3 logo-image">
        </a>
        </div>
        <div class="card card-md">
        <div class="card-body">
            <h3 class="text-center mb-4">APLIKASI MANAJEMEN DATABASE VENDOR</h3>
            <form method="POST" action="{{ route('login') }}" autocomplete="off" novalidate>
                @csrf
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" placeholder="your@email.com" autocomplete="off">
            </div>
            <div class="mb-2">
                <label class="form-label">
                Password
                </label>
                <div class="input-group input-group-flat">
                <input type="password" name="password" class="form-control"  placeholder="Your password"  autocomplete="off">
                </div>
            </div>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">Sign in</button>
            </div>
            </form>
        </div>
        </div>
        <div class="text-center text-secondary mt-3">
        Don't have account yet? <a href="{{ asset ('') }}assets/sign-up.html" tabindex="-1">Sign up</a>
        </div>
    </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="{{ asset ('') }}assets/dist/js/tabler.min.js?1685973381" defer></script>
    <script src="{{ asset ('') }}assets/dist/js/demo.min.js?1685973381" defer></script>
</body>
</html>
