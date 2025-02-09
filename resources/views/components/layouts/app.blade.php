<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <meta name="description" content="POS - Bootstrap Admin Template" />
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects" />
    <meta name="author" content="Dreamguys - Bootstrap Admin Template" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Dreams Pos Admin Template</title>

    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png" />

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @livewireStyles
</head>

<body>

    <div class="main-wrapper">
        @include('components.layouts.header')

        @if (Request::is('pos'))
            @livewire('pos.pos')
        @elseif (Request::is('hold'))
            @livewire('pos.list-hold')
        @elseif (Request::is('hold'))
            @livewire('pos.list-hold')
        @elseif (Request::is('transaction'))
            @livewire('pos.list-transaction')
        @elseif (Request::is('pos/*'))
        @php
            $holdId = Request::segment(2);
        @endphp
            @livewire('pos.hold-pos', ['holdId' => $holdId])
        @else
            @include('components.layouts.sidebar')

            <div class="page-wrapper">
                {{ $slot }}
            </div>
        @endif

    </div>


    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexchart/chart-data.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme-script.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        new DataTable('#example');
        document.addEventListener('DOMContentLoaded', function() {
            // MutationObserver untuk mendeteksi perubahan DOM
            const observer = new MutationObserver(() => {
                feather.replace(); // Render ulang feather icons
            });

            // Elemen yang akan dipantau (container utama di halaman Anda)
            const targetNode = document.querySelector('.content');

            // Konfigurasi observer untuk mendeteksi perubahan
            const config = {
                childList: true,
                subtree: true
            };

            if (targetNode) {
                observer.observe(targetNode, config);
            }
        });
    </script>

    <script>
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('#js-example-basic-single').select2();
        });
    </script>

    @livewireScripts
</body>

</html>
