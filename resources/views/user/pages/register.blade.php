<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Sisteme Kayıt Ol</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="{{asset("user/img/favicon.ico")}}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset("user/lib/owlcarousel/assets/owl.carousel.min.css")}}" rel="stylesheet">
    <link href="{{asset("user/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css")}}" rel="stylesheet"/>

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset("user/css/bootstrap.min.css")}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset("user/css/style.css")}}" rel="stylesheet">
</head>

<body>
<div class="container-xxl position-relative bg-white d-flex p-0">
    <!-- Spinner Start -->
    <div id="spinner"
         class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Sign In Start -->
    <div class="container-fluid">
        <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                    <div class="d-flex flex-column align-items-center justify-content-between mb-3">
                        <a href="{{route("front.home")}}" class="">
                            <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>OTO İHALE SİSTEMİ</h3>
                        </a>
                        <h3>Kayıt Ol</h3>
                    </div>
                    <form method="POST" action="{{route("user.register")}}">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="name" id="floatingInput"
                                   placeholder="İsim Soyisim">
                            <label for="floatingInput">İsim Soyisim</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" name="email" id="floatingInput"
                                   placeholder="Mail adresiniz">
                            <label for="floatingInput">Email Adresi</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="phone" id="floatingInput"
                                   placeholder="Telefon numaranız">
                            <label for="floatingInput">Telefon</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" name="password" id="floatingPassword"
                                   placeholder="Şifreniz">
                            <label for="floatingPassword">Şifre</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" name="password_confirmation"
                                   id="floatingPassword"
                                   placeholder="Şifre Tekrar">
                            <label for="floatingPassword">Şifre Tekrar</label>
                        </div>

                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Kayıt Ol</button>
                    </form>
                    @if (session('success'))
                        <div id="response" class="alert alert-success"
                             style="width: 400px; padding-top: 2px; display: flex; justify-content: center">
                            {{ session('success') }}
                        </div>
                    @elseif(session('error'))
                        <div id="response" class="alert alert-danger py-2 d-flex justify-content-center"
                             style="width: 400px; padding-top: 2px;  display: flex; justify-content: center">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Sign In End -->
</div>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{asset("user/lib/chart/chart.min.js")}}"></script>
<script src="{{asset("user/lib/easing/easing.min.js")}}"></script>
<script src="{{asset("user/lib/waypoints/waypoints.min.js")}}"></script>
<script src="{{asset("user/lib/owlcarousel/owl.carousel.min.js")}}"></script>
<script src="{{asset("user/lib/tempusdominus/js/moment.min.js")}}"></script>
<script src="{{asset("user/lib/tempusdominus/js/moment-timezone.min.js")}}"></script>
<script src="{{asset("user/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js")}}"></script>


<script>
    setTimeout(function () {
        document.getElementById('response').style.display = 'none';
    }, 2000);
</script>

<!-- Template Javascript -->
<script src="{{asset("user/js/main.js")}}"></script>
</body>

</html>
