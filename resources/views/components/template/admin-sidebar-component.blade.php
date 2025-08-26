<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="/">
            <img src="{{ isset($settings) ? $settings['logoImage'] : env('APP_LOGO') }}" class="navbar-brand-img h-100" alt="main_logo">
            <!-- <span class="ms-1 font-weight-bold text-white">{{ isset($settings) ? $settings['websiteName'] : env('APP_NAME') }}</span> -->
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2" />
    <div class="collapse navbar-collapse  w-auto" id="sidenav-collapse-main">
        <ul class="nav-list">
            @if ($getAccessRights('links'))
                <li class="nav-item">
                    <a class="nav-link-item {{ $isRouteParent('link') == 'active' ? 'active' : '' }}"  href="/admin/link/list">
                        <span class="icon-label">🔗</span>
                        <span class="nav-text">Links</span>
                        <i class="fas fa-chevron-down caret"></i>
                    </a>
                </li>
            @endif
            @if ($getAccessRights('settings'))
            <li class="nav-item">
                <a class="nav-link-item {{ $isRouteParent('setting') == 'active' ? 'active' : '' }}" data-bs-toggle="collapse" href="#settings-collapse">
                    <span class="icon-label">⚙️</span>
                    <span class="nav-text">Pengaturan</span>
                    <i class="fas fa-chevron-down caret"></i>
                </a>
                <div class="collapse {{ $isRouteParent('setting') == 'active' ? 'show' : '' }}" id="settings-collapse">
                    <ul class="nav-sub-list">
                        <li class="nav-sub-item">
                            <a class="nav-sub-link {{ $isRouteActive(['admin/setting/metatag']) }}" href="/admin/setting/metatag">
                                <span class="nav-text">Meta Tag</span>
                            </a>
                        </li>
                        <li class="nav-sub-item">
                            <a class="nav-sub-link {{ $isRouteActive(['admin/setting/view']) }}" href="/admin/setting/view">
                                <span class="nav-text">Tampilan</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif
            @if ($getAccessRights('admin_staff'))
            <li class="nav-item">
                <a class="nav-link-item {{ $isRouteParent('staff') == 'active' ? 'active' : '' }}" data-bs-toggle="collapse" href="#admin-staff-collapse">
                    <span class="icon-label">👥</span>
                    <span class="nav-text">Admin Staff</span>
                    <i class="fas fa-chevron-down caret"></i>
                </a>
                <div class="collapse {{ $isRouteParent('staff') == 'active' ? 'show' : '' }}" id="admin-staff-collapse">
                    <ul class="nav-sub-list">
                        <li class="nav-sub-item">
                            <a class="nav-sub-link {{ $isRouteActive(['admin/staff/list']) }}" href="/admin/staff/list">
                                <span class="nav-text">Daftar</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif
        </ul>
    </div>
</aside>
