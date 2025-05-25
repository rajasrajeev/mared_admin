{{-- To make an editable image or text, add a "builder editable" class and builder identity attribute with a unique value --}}
{{-- builder identity and builder editable --}}
{{-- builder identity value must be unique within a single file --}}

@php
    $parent_categories = DB::table('categories')->where('parent_id', 0)->latest('id')->get();
    $current_route = Route::currentRouteName();
@endphp

<!-----------  Header Area Start  ------------->
<header class="section rd-navbar-absolute-wrap" data-preset='{"title":"Navbar Default","category":"header","reload":true,"id":"navbar-default"}'>
    <nav class="rd-navbar" data-rd-navbar='{"responsive":{"1200":{"stickUpOffset":"80px"}}}'>
        <div class="navbar-container">
            <div class="navbar-cell">
                <div class="navbar-panel">
                    <button class="navbar-switch novi-icon custom-font-menu" data-multi-switch='{"targets":".rd-navbar","scope":".rd-navbar","isolate":"[data-multi-switch]"}'></button>
                    <div class="navbar-logo">
                        <a class="navbar-logo-link" href="index.html">
                            <img class="navbar-logo-inverse" src="{{ get_image(get_frontend_settings('dark_logo')) }}" alt="Mared Education" width="198" height="50" style="width: 150px;" />
                        </a>
                    </div>
                </div>
            </div>
            <div class="navbar-spacer"></div>

            {{-- Search Bar --}}
            <div class="navbar-cell">
                <div class="search-bar builder-editable" builder-identity="header-search-bar">
                    <input class="search-input" type="text" placeholder="Search for anything" name="s" />
                </div>
            </div>

            <div class="navbar-spacer"></div>

            {{-- Navigation Links and Buttons --}}
            <div class="navbar-cell navbar-sidebar">
                <ul class="navbar-navigation rd-navbar-nav">
                    <li class="navbar-navigation-root-item {{ $current_route == 'home' ? 'active' : '' }}">
                        <a class="navbar-navigation-root-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="navbar-navigation-root-item">
                        <a class="navbar-navigation-root-link" href="#">Contact us</a>
                    </li>
                    <li class="navbar-navigation-root-item">
                        <a class="btn btn-login" href="/login">Log in</a>
                    </li>
                    <li class="navbar-navigation-root-item">
                        <a class="btn btn-signup" href="/register">Sign up</a>
                    </li>
                </ul>
            </div>

            <div class="navbar-spacer"></div>

            {{-- Language Selector --}}
            <!--<div class="navbar-cell">-->
            <!--    <div class="language-selector builder-editable" builder-identity="header-language-selector">-->
            <!--        <button id="lng-selector" class="btn-language">🌐</button>-->
            <!--    </div>-->
            <!--</div>-->
        </div>
    </nav>
</header>
<!-----------  Header Area End   ------------->

@push('js')
    <script>
        "use strict";
        $(document).ready(function() {
            $('#lng-selector').change(function(e) {
                e.preventDefault();
                $(this).parent().trigger('submit');
            });
        });
    </script>
@endpush
