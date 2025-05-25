@php
$current_route = Route::currentRouteName();
@endphp

<div class="sidebar-logo-area">
    <a href="#" class="sidebar-logos">
        <img class="sidebar-logo-lg" height="50px" src="{{ get_image(get_frontend_settings('dark_logo')) }}" alt="">
        <img class="sidebar-logo-sm" height="40px" src="{{ get_image(get_frontend_settings('favicon')) }}" alt="">
    </a>
    <button class="sidebar-cross menu-toggler d-block d-lg-none">
        <span class="fi-rr-cross"></span>
    </button>
</div>

<h3 class="sidebar-title fs-12px px-30px pb-20px text-uppercase mt-4">{{ get_phrase('Main Menu') }}</h3>
<div class="sidebar-nav-area" style="overflow-y: auto; max-height: 80vh;">
    <nav class="sidebar-nav">
        <ul class="px-14px pb-24px">
            @foreach(get_menus() as $menu)
                @if (has_permission($menu->route))
                    @php
                        // Check if the current route matches the menu or any of its submenus
                        $isActive = $current_route == $menu->route;
                        $hasActiveSubmenu = $menu->submenus->contains(function($submenu) use ($current_route) {
                            return has_permission($submenu->route) && $current_route == $submenu->route;
                        });
                    @endphp

                    <li class="sidebar-first-li {{ $isActive || $hasActiveSubmenu ? 'active' : '' }} @if($menu->submenus->isNotEmpty()) first-li-have-sub @endif">
                        <a href="{{ $menu->submenus->isNotEmpty() ? 'javascript:void(0);' : route($menu->route) }}">
                            <span class="icon {{ $menu->icon }}"></span>
                            <div class="text">
                                <span>{{ get_phrase($menu->name) }}</span>
                            </div>
                        </a>
                        @if ($menu->submenus->isNotEmpty())
                            <ul class="first-sub-menu">
                                <li class="first-sub-menu-title fs-14px mb-18px">{{ get_phrase($menu->name) }}</li>
                                @foreach($menu->submenus as $submenu)
                                    @if (has_permission($submenu->route))
                                        <li class="sidebar-second-li {{ $current_route == $submenu->route ? 'active' : '' }}">
                                            <a href="{{ route($submenu->route) }}">{{ get_phrase($submenu->name) }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endif
            @endforeach
        </ul>
    </nav>
</div>

<script>
    "use strict";
    document.addEventListener("DOMContentLoaded", function() {
        const sidebarNavArea = document.querySelector('.sidebar-nav-area');

        // Restore scroll position if it exists in localStorage
        const scrollPos = localStorage.getItem('navScrollPos');
        if (scrollPos) {
            sidebarNavArea.scrollTop = scrollPos;
        }

        // Ensure the active element is visible
        const activeElement = sidebarNavArea.querySelector('.active');
        if (activeElement) {
            const sidebarNavRect = sidebarNavArea.getBoundingClientRect();
            const activeElementRect = activeElement.getBoundingClientRect();

            // Check if the active element is out of view
            if (activeElementRect.bottom > sidebarNavRect.bottom || activeElementRect.top < sidebarNavRect.top) {
                // Scroll the sidebar to the active element
                sidebarNavArea.scrollTop += activeElementRect.top - sidebarNavRect.top;
            }
        }

        // Save scroll position before page unload
        window.addEventListener('beforeunload', function() {
            localStorage.setItem('navScrollPos', sidebarNavArea.scrollTop);
        });
    });
</script>
