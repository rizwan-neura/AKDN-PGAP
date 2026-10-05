<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <div class="navbar-brand-box">
        <a href="{{ route('dashboard') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>

        <a href="{{ route('dashboard') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-light.png') }}" alt="" height="60">
            </span>
        </a>

        <button type="button"
                class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>

            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title">
                    <span>@lang('translation.menu')</span>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link"
                       href="#sidebarDashboards"
                       data-bs-toggle="collapse"
                       role="button"
                       aria-expanded="{{ request()->routeIs('dashboard') ? 'true' : 'false' }}"
                       aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-2-line"></i>
                        <span>@lang('translation.dashboards')</span>
                    </a>

                    <div class="collapse menu-dropdown {{ request()->routeIs('dashboard') ? 'show' : '' }}"
                         id="sidebarDashboards">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('dashboard') }}"
                                   class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                    @lang('translation.analytics')
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                @if(auth()->user()?->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link menu-link"
                           href="#sidebarUserManagement"
                           data-bs-toggle="collapse"
                           role="button"
                           aria-expanded="{{ request()->routeIs('users.*') ? 'true' : 'false' }}"
                           aria-controls="sidebarUserManagement">
                            <i class="ri-user-settings-line"></i>
                            <span>@lang('translation.user-management')</span>
                        </a>

                        <div class="collapse menu-dropdown {{ request()->routeIs('users.*') ? 'show' : '' }}"
                             id="sidebarUserManagement">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}"
                                       class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                                        @lang('translation.users')
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('users.access') }}"
                                       class="nav-link {{ request()->routeIs('users.access') ? 'active' : '' }}">
                                        Access Overview
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif

                <li class="menu-title">
                    <i class="ri-more-fill"></i>
                    <span>@lang('translation.components')</span>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link"
                       href="#sidebarForms"
                       data-bs-toggle="collapse"
                       role="button"
                       aria-expanded="{{ request()->routeIs('projects.*') ? 'true' : 'false' }}"
                       aria-controls="sidebarForms">
                        <i class="ri-file-list-3-line"></i>
                        <span>@lang('translation.forms')</span>
                    </a>

                    <div class="collapse menu-dropdown {{ request()->routeIs('projects.*') ? 'show' : '' }}"
                         id="sidebarForms">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('projects.create') }}"
                                   class="nav-link {{ request()->routeIs('projects.create') ? 'active' : '' }}">
                                    @lang('translation.create-project')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('projects.index') }}"
                                   class="nav-link {{ request()->routeIs('projects.index') ? 'active' : '' }}">
                                    @lang('translation.show-projects')
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="sidebar-background"></div>
</div>

<div class="vertical-overlay"></div>
