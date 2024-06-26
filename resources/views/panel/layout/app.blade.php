<!DOCTYPE html>

<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="{{asset("panel/assets/")}}"
    data-template="vertical-menu-template-free"
>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="utf-8"/>
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Yönetim Paneli</title>

    <meta name="description" content=""/>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset("front/resimler/logo.png")}}"/>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{asset("panel/assets/vendor/fonts/boxicons.css")}}"/>

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset("panel/assets/vendor/css/core.css")}}"
          class="template-customizer-core-css"/>
    <link rel="stylesheet" href="{{asset("panel/assets/vendor/css/theme-default.css")}}"
          class="template-customizer-theme-css"/>
    <link rel="stylesheet" href="{{asset("panel/assets/css/demo.css")}}"/>

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset("panel/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css")}}"/>

    <link rel="stylesheet" href="{{asset("panel/assets/vendor/libs/apex-charts/apex-charts.css")}}"/>

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{asset("panel/assets/vendor/js/helpers.js")}}"></script>
    <script src="{{ asset('panel/js/swiper-element-bundle.min.js') }}"></script>

    <script src="{{asset("panel/assets/js/config.js")}}"></script>
    <style>
        swiper-container {
      width: 100%;
      height: 100%;
    }

    swiper-slide {
      text-align: center;
      font-size: 18px;
      background: #fff;
      /* display: flex; */
      justify-content: center;
      align-items: center;
    }

    swiper-slide img {
      display: block;
      width: 100%;
      height: 250px;
      object-fit: cover;
    }
    </style>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


    <!-- Bootstrap JS ve Popper.js (jQuery'ye benzer bir kütüphane) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


</head>

<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->

        @include("panel.inc.sidebar")
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->

            @include("panel.inc.navbar")

            <!-- / Navbar -->
            <x-modal/>
            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->
                <div class="container-xxl flex-grow-1 container-p-y">

                    @yield('content')
                </div>
                <!-- / Content -->

                <!-- Footer -->
                @include("panel.inc.footer")
                <!-- / Footer -->

                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{asset("panel/assets/vendor/libs/jquery/jquery.js")}}"></script>
<script src="{{asset("panel/assets/vendor/libs/popper/popper.js")}}"></script>
<script src="{{asset("panel/assets/vendor/js/bootstrap.js")}}"></script>
<script src="{{asset("panel/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js")}}"></script>

<script src="{{asset("panel/assets/vendor/js/menu.js")}}"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{asset("panel/assets/vendor/libs/apex-charts/apexcharts.js")}}"></script>

<!-- Main JS -->
<script src="{{asset("panel/assets/js/main.js")}}"></script>

<!-- Page JS -->
<script src="{{asset("panel/assets/js/dashboards-analytics.js")}}"></script>

<script>
    setTimeout(function () {
        document.getElementById('response').style.display = 'none';
    }, 2000);
</script>
<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
</body>
</html>
