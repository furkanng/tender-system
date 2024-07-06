<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>{{$general["site_title"]}}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta content="{{$general["site_keywords"]}}" name="keywords"/>
    <meta content="{{$general["site_description"]}}" name="description"/>

    <!-- Favicon -->
    <link href="{{asset("front/resimler/logo.png")}}" rel="icon"/>

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap"
        rel="stylesheet"
    />

    <!-- Icon Font Stylesheet -->
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
        rel="stylesheet"
    />
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
        rel="stylesheet"
    />

    <!-- Libraries Stylesheet -->
    <link href="{{asset("front/lib/animate/animate.min.css")}}" rel="stylesheet"/>
    <link href="{{asset("front/lib/owlcarousel/assets/owl.carousel.min.css")}}" rel="stylesheet"/>

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset("front/css/bootstrap.min.css")}}" rel="stylesheet"/>

    <!-- Template Stylesheet -->
    <link href="{{asset("front/css/style.css")}}" rel="stylesheet"/>
</head>

<body>
<div class="container-xxl bg-white p-0">
    <!-- Spinner Start -->
    <div
        id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center"
    >
        <div
            class="spinner-border text-primary"
            style="width: 3rem; height: 3rem"
            role="status"
        >
            <span class="sr-only">Yükleniyor...</span>
        </div>
    </div>
    <!-- Spinner End -->

    @include("front.inc.navbar")

    @yield('content')

    @include("front.inc.footer")

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"
    ><i class="bi bi-arrow-up"></i
        ></a>
</div>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{asset("front/lib/wow/wow.min.js")}}"></script>
<script src="{{asset("front/lib/easing/easing.min.js")}}"></script>
<script src="{{asset("front/lib/waypoints/waypoints.min.js")}}"></script>
<script src="{{asset("front/lib/owlcarousel/owl.carousel.min.js")}}"></script>

<script>
    setTimeout(function () {
        document.getElementById('response').style.display = 'none';
    }, 2000);
</script>

<!-- Template Javascript -->
<script src="{{asset("front/js/main.js")}}"></script>
</body>
</html>
