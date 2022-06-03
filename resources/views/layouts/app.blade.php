<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">



    <title>{{ config('app.name', 'Portal da Transparência') }} @yield('title')</title>
    <meta name="keywords" content="{{ config('application.meta-keywords') }}">
    @yield('meta-description')
    @livewireStyles
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <link rel="shortcut icon" href="{{ asset(config('application.favico')) }}" type="image/x-icon">
    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap/bootstrap.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/fontawesome-free/css/all.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/cookie-consent/css/cookie-consent.css') }}">
    <style media="print">
        @page {
            size: auto A4 landscape !important;
            margin: 15mm !important;
        }

    </style>


</head>

<body class="font-sans antialiased" style="font-size: 14px">
    @include('layouts.navigation')
    <div class="my-4">
        {{ $slot }}
    </div>
    </div>
    @include('layouts.footer')
    @include('vendor.cookie-consent.index')
    @if (config('application.enable_vlibras'))
        <div vw class="enabled">
            <div vw-access-button class="active"></div>
            <div vw-plugin-wrapper>
                <div class="vw-plugin-top-wrapper"></div>
            </div>
        </div>
        <script type="text/javascript" src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
        <script>
            new window.VLibras.Widget('https://vlibras.gov.br/app');
        </script>
    @endif
    @livewireScripts

    <script type="text/javascript" src="{{ asset('vendor/jquery/jquery.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/bootstrap/bootstrap.bundle.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('vendor/cookie-consent/js/cookie-consent.js') }}"></script>
    @if (config('application.analitic'))
        <!-- Matomo -->
        <script>
            var _paq = window._paq = window._paq || [];
            /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
            _paq.push(['trackPageView']);
            _paq.push(['enableLinkTracking']);
            (function() {
                var u = "https://analitic.crcro.org.br/";
                _paq.push(['setTrackerUrl', u + 'matomo.php']);
                _paq.push(['setSiteId', '2']);
                var d = document,
                    g = d.createElement('script'),
                    s = d.getElementsByTagName('script')[0];
                g.async = true;
                g.src = u + 'matomo.js';
                s.parentNode.insertBefore(g, s);
            })();
        </script>
        <!-- End Matomo Code -->
    @endif
    @yield('js')
    @stack('js')

</body>



</html>
