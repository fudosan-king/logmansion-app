<aside class="main-sidebar {{ config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4') }}">

    {{-- Sidebar brand logo --}}
    @if(config('adminlte.logo_img_xl'))
        @include('adminlte::partials.common.brand-logo-xl')
    @else
        @include('adminlte::partials.common.brand-logo-xs')
    @endif

    {{-- Sidebar menu --}}
    <div class="sidebar">
        <nav class="pt-2">
            <ul class="nav nav-pills nav-sidebar flex-column {{ config('adminlte.classes_sidebar_nav', '') }}"
                data-widget="treeview" role="menu"
                @if(config('adminlte.sidebar_nav_animation_speed') != 300)
                    data-animation-speed="{{ config('adminlte.sidebar_nav_animation_speed') }}"
                @endif
                @if(!config('adminlte.sidebar_nav_accordion'))
                    data-accordion="false"
                @endif>
                {{-- Configured sidebar links --}}
                
                @php 
                     $menu = $adminlte->menu('sidebar'); 
                    // if (isset(Auth::user()->roles[0]->name) && Auth::user()->roles[0]->name != config('permission.superadmin')) {
                    //     unset($menu[3]);
                    // }
                @endphp 

{{-- @php
// echo "<pre>"; print_r($menu); echo "</pre>";
@endphp --}}

                @each('adminlte::partials.sidebar.menu-item', $menu, 'item')
            </ul>
        </nav>
    </div>

</aside>
