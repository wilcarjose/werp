<!-- ============================-->
<!-- Vertical Navigation (Default and Iconized)-->
<!-- ============================-->
<div class="vertical-navigations animated">
    <ul class="side-nav fixed animated collapsible collapsible-accordion" id="nav-default">
        <li class="logo">
            <a class="brand-logo hide-on-large-only" id="logo-container" href="{{ url('/admin') }}"></a>
        </li>
        <li class="usr-profile">
            <div class="usr-profile-header">
                <a href="#">
                    <img class="circle" src="{{ Auth::user()->pic?Storage::url(Auth::user()->pic):url('/images/square/male_6.jpg') }}" alt="Hexesis">
                </a>
            </div>
            <ul class="user-options">
                <li class="waves-effect waves-set">
                    <span class="usr-name">{{ ucwords(Auth::user()->name) }}</span>
                </li>
                <li class="user-option-item waves-effect waves-set">
                    <a class="btn-floating btn-small waves-effect waves-light" href="#">
                        <i class="material-icons">lock</i>
                    </a>
                </li>
                <li class="user-option-item waves-effect waves-set">
                    <a class="btn-floating btn-small waves-effect waves-light" href="{{ url('/admin/profile') }}">
                        <i class="material-icons">settings</i>
                    </a>
                </li>
                <li class="user-option-item waves-effect waves-set">
                    <a class="btn-floating btn-small waves-effect waves-light" href="{{ url('/admin/logout') }}"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="material-icons">power_settings_new</i>
                    </a>
                    <form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </li>
        <li>
            <a class="collapsible-header no-col-body waves-effect waves-set" href="{{ url('/admin') }}">
                <i class="material-icons">dashboard</i>
                <span>@lang('view.dashboard')</span>
            </a>
        </li>

        @if(auth()->user()->can('developerOnly') || auth()->user()->can('role') || auth()->user()->can('admin.list'))
        <li class="navigation-header">
            <span class="no-col-body">@lang('view.modules')</span>
            <i class="material-icons tooltipped" data-position="right" data-delay="50" data-tooltip="ADMINISTRATING">more_horiz</i>
        </li>
        @endif

        @if(auth()->user()->can('developerOnly') || auth()->user()->can('role'))
            @foreach (config('menu') as $module) 
                <li>
                    <a class="collapsible-header waves-effect waves-set {{ in_array($current_route_name, $module['routes'])?'active current':'' }}" href="#">
                        <i class="material-icons">{{ $module['icon'] }}</i><span>@lang($module['module'])</span>
                        <i class="material-icons mdi-navigation-chevron-left">keyboard_arrow_left</i>
                    </a>
                    <div class="collapsible-body">
                      <ul>
                        @foreach ($module['items'] as $item)
                            <li class="menu-item">
                                <a class="waves-effect waves-set {{ $current_route_name == $item['route'] ? 'active' : '' }}" href="{{ route($item['route']) }}"><span>@lang($item['name'])</span></a>
                            </li>
                        @endforeach
                      </ul>
                    </div>
                </li>
            @endforeach
        @endif

        @if(auth()->user()->can('developerOnly') || auth()->user()->can('role'))
        <li>
            <a class="collapsible-header waves-effect waves-set {{ in_array($current_route_name,['admin.roles.index','admin.permissions.index','admin.myrolepermission'])?'active current':'' }}" href="#">
                <i class="material-icons">security</i><span>@lang('view.menu.roles')</span>
                <i class="material-icons mdi-navigation-chevron-left">keyboard_arrow_left</i>
            </a>
            <div class="collapsible-body">
              <ul>
                <li class="menu-item">
                    <a class="waves-effect waves-set {{ $current_route_name=='admin.roles.index'?'active':'' }}" href="{{ url('/admin/roles') }}"><span>@lang('view.menu.roles')</span></a>
                </li>
                @can('developerOnly')
                <li class="menu-item">
                    <a class="waves-effect waves-set {{ $current_route_name=='admin.permissions.index'?'active':'' }}" href="{{ url('/admin/permissions') }}"><span>@lang('view.menu.permissions')</span></a>
                </li>
                @endcan
                <li class="menu-item">
                    <a class="waves-effect waves-set {{ $current_route_name == 'admin.myrolepermission'? 'active': '' }}" href="{{ url('/admin/rolePermissions') }}">
                        <span>@lang('view.menu.assign_permissions')</span>
                    </a>
                </li>
              </ul>
            </div>
        </li>
        @endif

        @if(auth()->user()->can('developerOnly') || auth()->user()->can('admin.list'))
        <li>
            <a class="collapsible-header no-col-body waves-effect waves-set {{ $current_route_name=='admin.administrator.index'?'active':'' }}"
                href="{{ url('/admin/administrator') }}">
                <i class="material-icons">verified_user</i><span>@lang('view.menu.administrators')</span>
            </a>
        </li>
        @endif

        @if(auth()->user()->can('developerOnly') || auth()->user()->can('user'))
        <li>
            <a class="collapsible-header waves-effect waves-set {{ in_array($current_route_name,['admin.user.index', 'admin.user.create', 'admin.user.store', 'admin.user.update', 'admin.user.edit'])?'active current':'' }}" href="#">
                <i class="material-icons">group</i><span>@lang('view.menu.users')</span>
                <i class="material-icons mdi-navigation-chevron-left">keyboard_arrow_left</i>
            </a>
            <div class="collapsible-body">
              <ul>
                <li class="menu-item">
                    <a class="waves-effect waves-set {{ $current_route_name=='admin.user.index'?'active':'' }}" href="{{ url('/admin/user') }}"><span>@lang('view.menu.list')</span></a>
                </li>
                <li class="menu-item">
                    <a class="waves-effect waves-set {{ $current_route_name=='admin.user.create'?'active':'' }}" href="{{ url('/admin/user/create') }}"><span>@lang('view.menu.add')</span></a>
                </li>
              </ul>
            </div>
        </li>
        @endif
    </ul>
</div>
