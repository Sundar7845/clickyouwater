@php
    if (Auth::user()->role_id == 1) {
        $getMenuId = App\Models\Menu::pluck('id as menu_id')->implode(',');
    } else {
        $getMenuId = App\Models\RolePermission::where('role_id', '=', Auth::user()->role_id)
            ->pluck('menu_id')
            ->first();
    }
    if ($getMenuId) {
        $getMenuName = explode(',', $getMenuId);
        if (Auth::user()->id == 1) {
            $menu = App\Models\Menu::where('is_mainmenu', '=', 1)
            ->whereIn('id', $getMenuName)
            ->where('is_visible', 1)
            ->where('show_superadmin', 1)
            ->orderBy('menu_order', 'ASC')
            ->get();
        } else {
            $menu = App\Models\User::select('menus.*', 'user_role_permissions.user_id', 'user_role_permissions.is_edit', 'user_role_permissions.is_delete', 'user_role_permissions.is_view', 'user_role_permissions.is_print', 'user_role_permissions.is_approval')
                ->join('user_role_permissions', 'users.id', 'user_role_permissions.user_id')
                ->join('menus', 'menus.id', 'user_role_permissions.menu_id')
                ->whereIn('menus.id', $getMenuName)
                ->where('menus.is_mainmenu', '=', 1)
                ->where('menus.is_visible', '=', 1)
                ->where('users.id', '=', Auth::user()->id)
                ->orderBy('menu_order', 'ASC')
                ->get();
        }
    }
@endphp

<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <img src="{{ asset('assets/img/layouts/logos.jpeg') }}" class="img-fluid img-responsive" alt=""
                id="logo-img">
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto" onclick="toggleMenu()">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <!-- Layouts -->
        @if (isset($menu))
            @foreach ($menu as $item)
                <li class="menu-item">
                    @php
                        if (Auth::user()->role_id == 1) {
                            $getMenuId = App\Models\Menu::pluck('id as menu_id')->implode(',');
                        } else {
                            $getMenuId = App\Models\RolePermission::where('role_id', '=', Auth::user()->role_id)
                                ->pluck('menu_id')
                                ->first();
                        }
                        $getMenuName = explode(',', $getMenuId);
                        // dd($getMenuName);
                        if ($getMenuId) {
                            if (Auth::user()->id == 1) {
                                $submenu = App\Models\Menu::where('parent_id', $item->id)
                                    ->whereIn('id', $getMenuName)
                                    ->where('is_visible', 1)
                                    ->where('show_superadmin', 1)
                                    ->orderBy('menu_order', 'ASC')
                                    ->get();
                            } else {
                                $submenu = App\Models\User::select('menus.*', 'user_role_permissions.user_id', 'user_role_permissions.is_edit', 'user_role_permissions.is_delete', 'user_role_permissions.is_view', 'user_role_permissions.is_print', 'user_role_permissions.is_approval')
                                    ->join('user_role_permissions', 'users.id', 'user_role_permissions.user_id')
                                    ->join('menus', 'menus.id', 'user_role_permissions.menu_id')
                                    ->whereIn('menus.id', $getMenuName)
                                    ->where('menus.is_visible', '=', 1)
                                    ->where('menus.parent_id', $item->id)
                                    ->where('users.id', '=', Auth::user()->id)
                                    ->orderBy('menu_order', 'ASC')
                                    ->get();
                            }
                        }
                    @endphp
                    <a href="{{ $item->menu_url }}"
                        class="menu-link @if ($submenu->count() > 0) menu-toggle @endif">
                        <i class="{{ $item->icon }}"></i>
                        <div data-i18n="{{ $item->menu_name }}">{{ $item->menu_name }}</div>
                    </a>

                    <ul class="menu-sub">
                        @foreach ($submenu as $submenuitem)
                            <li class="menu-item">
                                <a href="{{ $submenuitem->menu_url }}" class="menu-link">
                                    <div data-i18n="{{ $submenuitem->menu_name }}">{{ $submenuitem->menu_name }}</div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        @endif
    </ul>

</aside>
<!-- / Menu -->
<script>
    function toggleMenu() {
        var logoImg = document.getElementById("logo-img");
        if (logoImg.src.includes("logos.jpeg")) {
            logoImg.src = "{{ asset('assets/img/layouts/toggle-logo.png') }}";
            logoImg.style.width = "40px";
            logoImg.style.height = "50px";
        } else {
            logoImg.src = "{{ asset('assets/img/layouts/logos.jpeg') }}";
            logoImg.style.width = null;
            logoImg.style.height = null;
        }
    }
</script>
