<!-- Sidebar Start -->
<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="{{route("user.home")}}" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary" style="font-size: larger"><i class="fa fa-hashtag me-2"></i>Oto İhale Sistemi</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="{{asset("user/img/user.jpg")}}" alt=""
                     style="width: 40px; height: 40px;">
                <div
                    class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">{{strtolower(auth()->guard("user")->user()->name)}}</h6>
                <span>
                    @if(auth()->guard("user")->user()->role == 1)
                        Onaylı
                    @else
                        VIP
                    @endif
                </span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <a href="{{route("user.home")}}" class="nav-item nav-link active"><i class="fa fa-home me-2"></i>Ana
                Sayfa</a>
            <a href="{{route("user.tender.index")}}" class="nav-item nav-link"><i class="fa fa-car me-2"></i>Tüm
                İhaleler</a>
            <a href="{{route("user.bid.index")}}" class="nav-item nav-link"><i
                    class="fa fa-car me-2"></i>Tekliflerim</a>
            <a href="{{route('user.archive.index')}}" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Arşiv</a>
            <a href="{{route("user.support.index")}}" class="nav-item nav-link"><i class="bx bx-support me-2"></i>Destek
                Talebi</a>
            <a href="{{route("user.profile.index")}}" class="nav-item nav-link"><i class='bx bx-user me-2'></i></i>
                Profilim</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                        class="far fa-file-alt me-2"></i>Pages</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="signin.html" class="dropdown-item">Sign In</a>
                    <a href="signup.html" class="dropdown-item">Sign Up</a>
                    <a href="404.html" class="dropdown-item">404 Error</a>
                    <a href="blank.html" class="dropdown-item">Blank Page</a>
                </div>
            </div>
        </div>
    </nav>
</div>
<!-- Sidebar End -->
