<aside class="sidebar-menu sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3">
    <div class="sidebar-header">
        <i class="fas fa-times p-3 cursor-pointer sidebar-toggle-btn d-none d-xl-none"></i>
        <a class="logo-link" href="/">
            <img src="{{ isset($settings) ? $settings['logoImage'] : env('APP_LOGO') }}" class="logo-img" alt="main_logo">
        </a>
    </div>
    <hr class="sidebar-divider" />
    <div class="sidebar-content">
        <ul class="nav-list">
            @if ($getAccessRights('links'))
                <li class="nav-item">
                    <a class="nav-link-item {{ $isRouteParent('link') == 'active' ? 'active' : '' }}" data-bs-toggle="collapse" href="#link-collapse">
                        <span class="icon-label">🔗</span>
                        <span class="nav-text">Links</span>
                        <i class="fas fa-chevron-down caret"></i>
                    </a>
                    <div class="collapse {{ $isRouteParent('link') == 'active' ? 'show' : '' }}" id="link-collapse">
                        <ul class="nav-sub-list">
                            <li class="nav-sub-item">
                                <a class="nav-sub-link {{ $isRouteActive(['admin/link/list']) }}" href="/admin/link/list">
                                    <span class="nav-text">Daftar Link</span>
                                </a>
                            </li>
                            <li class="nav-sub-item">
                                <a class="nav-sub-link {{ $isRouteActive(['admin/link/new']) }}" href="/admin/link/new">
                                    <span class="nav-text">Form Link</span>
                                </a>
                            </li>
                        </ul>
                    </div>
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
