<!-- Sidebar Start -->
<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="{{route("user.home")}}" class="navbar-brand mx-4 mb-3">
            <img src="{{ asset('front/resimler/logo.png') }}" alt="logo" width="100px" srcset="">
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                @if(empty($user->image))
                    <img class="rounded-circle" src="{{ asset('user/img/no_profile.png') }}"
                         style="width: 40px; height: 40px;">
                @else
                    <img class="rounded-circle" src="{{ url('storage/users/'.$user->image) }}"
                         style="width: 40px; height: 40px;">
                @endif

                <div
                    class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1">
                </div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">{{ mb_strtoupper(auth()->guard("user")->user()->name, 'UTF-8') }}</h6>
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
            <a href="{{ route('user.home') }}"
               class="nav-item nav-link {{ request()->routeIs('user.home') ? 'active' : '' }}">
                <i class="fa fa-home me-2"></i>Ana Sayfa
            </a>
            @php $user = auth()->guard("user")->user()  @endphp
            @if(!empty($user->city) && !empty($user->district) && !empty($user->address) && !empty($user->phone))
                <a href="{{ route('user.tender.index') }}"
                   class="nav-item nav-link {{ request()->routeIs('user.tender.index') ? 'active' : '' }}">
                    <i class="fa fa-car me-2"></i>Tüm İhaleler
                </a>
                <a href="{{ route('user.bid.index') }}"
                   class="nav-item nav-link {{ request()->routeIs('user.bid.index') ? 'active' : '' }}">
                    <i class="fa fa-car me-2"></i>Tekliflerim
                </a>
                <a href="{{ route('user.archive.index') }}"
                   class="nav-item nav-link {{ request()->routeIs('user.archive.index') ? 'active' : '' }}">
                    <i class="fa fa-table me-2"></i>Arşiv
                </a>
            @endif

            <a href="{{ route('user.support.index') }}"
               class="nav-item nav-link {{ request()->routeIs('user.support.index') ? 'active' : '' }}">
                <i class="bx bx-support me-2"></i>Destek Talebi
            </a>
            <a href="{{ route('user.profile.index') }}"
               class="nav-item nav-link {{ request()->routeIs('user.profile.index') ? 'active' : '' }}">
                <i class='bx bx-user me-2'></i> Profilim
            </a>
        </div>

    </nav>
</div>
<!-- Sidebar End -->
