<!-- Navbar Start -->
<div class="container-fluid nav-bar bg-transparent">
    <nav class="navbar navbar-expand-lg bg-white navbar-light py-0 px-4">
        <a
            href="#"
            class="navbar-brand d-flex align-items-center text-center"
        >
            <div class="icon p-2 me-2">
                <img
                    class="img-fluid"
                    src="{{asset("front/resimler/logo.png")}}"
                    alt="Icon"
                    style="width: 60px; height: 30px"
                />
            </div>
            <h1 class="m-0 text-primary" style="font-size: small">OTO İHALE SİSTEMİ</h1>
        </a>
        <button
            type="button"
            class="navbar-toggler"
            data-bs-toggle="collapse"
            data-bs-target="#navbarCollapse"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto">
                <a href="{{route("front.home")}}" class="nav-item nav-link">Ana Sayfa</a>
                <a href="{{route("front.about")}}" class="nav-item nav-link">Kurumsal</a>
                <a href="{{route("front.contact")}}" class="nav-item nav-link">İLETİŞİM</a>
                <a href="{{route("front.login")}}" class="nav-item nav-link text-success"
                >Giriş Yap</a
                >
                <a href="{{route("front.register")}}" class="nav-item nav-link text-info"
                >Üye Ol</a
                >
            </div>
        </div>
    </nav>
</div>
<!-- Navbar End -->
