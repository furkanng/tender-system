<nav
    class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar"
>
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search
        <div class="navbar-nav align-items-center">
            <div class="nav-item d-flex align-items-center">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input
                        type="text"
                        class="form-control border-0 shadow-none"
                        placeholder="Ara..."
                        aria-label="Ara..."
                />
            </div>
        </div>
        -->

        <ul class="navbar-nav flex-row align-items-center ms-auto">

            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        @if(empty(auth()->guard("admin")->user()->image))
                            <img src="{{asset("panel/assets/img/avatars/no_profile.png")}}" alt
                                 class="w-px-40 h-auto rounded-circle"/>
                        @else
                            <img src="{{ url('storage/admin/'.auth()->guard("admin")->user()->image) }}" alt
                                 class="w-px-40 h-auto rounded-circle"/>
                        @endif

                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        @if(empty(auth()->guard("admin")->user()->image))
                                            <img src="{{asset("panel/assets/img/avatars/no_profile.png")}}" alt
                                                 class="w-px-40 h-auto rounded-circle"/>
                                        @else
                                            <img src="{{ url('storage/admin/'.auth()->guard("admin")->user()->image) }}"
                                                 alt
                                                 class="w-px-40 h-auto rounded-circle"/>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span
                                        class="fw-semibold d-block">{{strtolower(auth()->guard("admin")->user()->name)}}</span>
                                    <small class="text-muted">Admin</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('panel.profile.index') }}">
                            <i class="bx bx-user me-2"></i>
                            <span class="align-middle">Profilim</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('panel.general.index') }}">
                            <i class="bx bx-cog me-2"></i>
                            <span class="align-middle">Ayarlar</span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{route("panel.logout")}}">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="align-middle">Çıkış Yap</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>
</nav>
