<div class="nk-sidebar nk-sidebar-fixed is-light " data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-sidebar-brand">
            <a href="/" class="logo-link nk-sidebar-logo">
                <img class="logo-light logo-img" src="{{asset('images/logo.png')}}"  alt="logo">
                <img class="logo-dark logo-img" src="{{asset('images/logo-dark.png')}}"  alt="logo-dark">
                <img class="logo-small logo-img logo-img-small" src="{{asset('images/logo-small.png')}}" alt="logo-small">
            </a>
        </div>
        <div class="nk-menu-trigger me-n2">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
            <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
        </div>
    </div><!-- .nk-sidebar-element -->
    <div class="nk-sidebar-element">
        <div class="nk-sidebar-content">
            <div class="nk-sidebar-menu" data-simplebar>
                <ul class="nk-menu">
                    <router-link :to="{name: 'Home'}">
                        <li class="nk-menu-item">
                            <a href="#" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-home-fill"></em></span>
                                <span class="nk-menu-text">Trang chủ</span>
                            </a>
                        </li><!-- .nk-menu-item -->
                    </router-link>
                    <router-link :to="{name: 'NhiemVu_List'}">
                        <li class="nk-menu-item">
                            <a href="#" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-todo-fill"></em></span>
                                <span class="nk-menu-text">Nhiệm vụ</span>
                            </a>
                        </li><!-- .nk-menu-item -->
                    </router-link>
                    <router-link :to="{name: 'Notifications'}">
                        <li class="nk-menu-item">
                            <a href="#" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-bell-fill"></em></span>
                                <span class="nk-menu-text">Thông báo nhiệm vụ</span><span class="nk-menu-badge">10</span>
                            </a>
                        </li><!-- .nk-menu-item -->
                    </router-link>
                </ul><!-- .nk-menu -->
            </div><!-- .nk-sidebar-menu -->
        </div><!-- .nk-sidebar-content -->
    </div><!-- .nk-sidebar-element -->
</div>
