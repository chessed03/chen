<div class="left-side-menu">

    <div class="slimscroll-menu">

        <div id="sidebar-menu">

            <ul class="metismenu" id="side-menu">

                <li class="menu-title">NAVEGACIÓN

                    @foreach (__getMenuSidebar__() as $menu)

                        @php
                            $mandatoryRoute = "{$menu->menu}.";
                            $currentRoute   = Str::replace(['/', $mandatoryRoute], ['.', ''], request()->path());
                        @endphp

                        <li>

                            <a href="{{ ($menu->route === '#') ? $menu->route : route($menu->route) }}">
                                <i class="{{ $menu->icon }}"></i>
                                <span> {{ $menu->name }} </span>
                                @if ($menu->submenu)<span class="menu-arrow"></span> @endif
                            </a>
                            
                            @if ($menu->submenu)
                                <ul class="nav-second-level" aria-expanded="false">
                                    @foreach ($menu->itemsSubmenu as $submenu)
                                        <li>
                                            <a href="{{ route($submenu->route) }}"><i class="la {{ $currentRoute === $submenu->menu ? 'la-toggle-on' : 'la-toggle-off' }} mr-1"></i> {{ $submenu->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                        </li>
                        
                    @endforeach

                </li>
                
            </ul>

        </div>

    </div>

</div>