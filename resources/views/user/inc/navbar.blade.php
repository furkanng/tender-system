<!-- Navbar Start -->
<nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
    <div class="toggle_button">
        <a href="#" class="sidebar-toggler flex-shrink-0">
            <i class="fa fa-bars"></i>
        </a>
    </div>

    <div class="user-logo">
        <a href="{{route("user.home")}}" class="navbar-brand d-flex d-lg-none me-4">
            <img src="{{ asset('front/resimler/logo.png') }}" alt="logo" width="70px" srcset="">
        </a>
    </div>

    <div class="navbar-nav align-items-center ms-auto">
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">

                @if(empty($user->image))
                    <img class="rounded-circle me-lg-2" src="{{ asset('user/img/no_profile.png') }}"
                         style="width: 40px; height: 40px;">
                @else
                    <img class="rounded-circle me-lg-2" src="{{ url('storage/users/'.$user->image) }}"
                         style="width: 40px; height: 40px;">
                @endif

                <span class="d-none d-lg-inline-flex">
                    {{ mb_strtoupper(auth()->guard("user")->user()->name, 'UTF-8') }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                <a href="{{route("user.profile.index")}}" class="dropdown-item">Profilim</a>
                <a href="#" class="dropdown-item">Ayarlar</a>
                <a href="{{route("user.logout")}}" class="dropdown-item">Çıkış Yap</a>
            </div>
        </div>
    </div>
</nav>
<!-- Navbar End -->
