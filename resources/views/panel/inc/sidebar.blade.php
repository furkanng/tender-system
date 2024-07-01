<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('panel.home') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('front/resimler/logo.png') }}" alt="logo" width="100px" srcset="">
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">Yönetim</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('panel.home') ? 'active' : '' }}">
            <a href="{{ route('panel.home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Panel</div>
            </a>
        </li>
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Ayarlar</span></li>
        <li class="menu-item {{ request()->routeIs('panel.general.index') ? 'active' : '' }}">
            <a href="{{ route('panel.general.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div data-i18n="Tables">Genel Ayarlar</div>
            </a>
        </li>
        <!-- Layouts -->
        <li class="menu-item {{ request()->routeIs('panel.contact.index', 'panel.api.index', 'panel.mail.index', 'panel.media.index') ? 'active menu-open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Site Yönetimi</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('panel.contact.index') ? 'active' : '' }}">
                    <a href="{{ route('panel.contact.index') }}" class="menu-link">
                        <div data-i18n="Without menu">İletişim Ayarları</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('panel.api.index') ? 'active' : '' }}">
                    <a href="{{ route('panel.api.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Api Ayarları</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('panel.mail.index') ? 'active' : '' }}">
                    <a href="{{ route('panel.mail.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Mail Ayarları</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('panel.media.index') ? 'active' : '' }}">
                    <a href="{{ route('panel.media.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Sosyal Medya Ayarları</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-header small text-uppercase"><span class="menu-header-text">SİSTEM</span></li>
        <li class="menu-item {{ request()->routeIs('panel.tender.index', 'panel.tender.create') ? 'active menu-open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">İhale Yönetimi</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('panel.tender.index') ? 'active' : '' }}">
                    <a href="{{ route('panel.tender.index') }}" class="menu-link">
                        <div data-i18n="Account">İhaleler</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('panel.tender.create') ? 'active' : '' }}">
                    <a href="{{ route('panel.tender.create') }}" class="menu-link">
                        <div data-i18n="Notifications">İhale Ekle</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ request()->routeIs('panel.archive.index') ? 'active' : '' }}">
            <a href="{{ route('panel.archive.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-table"></i>
                <div data-i18n="Tables">Arşiv Yönetimi</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('panel.bid.index', 'panel.transferBid') ? 'active menu-open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cube-alt"></i>
                <div data-i18n="Misc">Teklifler</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('panel.bid.index') ? 'active' : '' }}">
                    <a href="{{ route('panel.bid.index') }}" class="menu-link">
                        <div data-i18n="Error">Gelen Teklifler</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('panel.transferBid') ? 'active' : '' }}">
                    <a href="{{ route('panel.transferBid') }}" class="menu-link">
                        <div data-i18n="Under Maintenance">Aktarılan Teklifler</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-header small text-uppercase"><span class="menu-header-text">Kullanıcılar</span></li>

        <li class="menu-item {{ request()->routeIs('panel.user.index', 'panel.user.create') ? 'active menu-open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Kullanıcı Yönetimi</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('panel.user.index') ? 'active' : '' }}">
                    <a href="{{ route('panel.user.index') }}" class="menu-link">
                        <div data-i18n="Account">Kullanıcı Listesi</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('panel.user.create') ? 'active' : '' }}">
                    <a href="{{ route('panel.user.create') }}" class="menu-link">
                        <div data-i18n="Notifications">Kullanıcı Ekle</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ request()->routeIs('panel.support.index') ? 'active' : '' }}">
            <a href="{{ route('panel.support.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-support"></i>
                <div data-i18n="Support">Destek Merkezi</div>
            </a>
        </li>
    </ul>
</aside>
