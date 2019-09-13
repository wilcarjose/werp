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
                <span style="font-weight: 300;
                            font-size: 13px;
                            text-transform: uppercase;">@lang('view.dashboard')</span>
            </a>
        </li>

        @if (false)
        <li class="navigation-header">
            <span class="no-col-body" style="font-weight: 300;
                                            font-size: 13px;
                                            text-transform: uppercase;">@lang('view.modules')</span>
            <i class="material-icons tooltipped" data-position="right" data-delay="50" data-tooltip="ADMINISTRATING">more_horiz</i>
        </li>
        @endif

        @foreach (config('menu') as $module) 
            {{--  @if (auth()->user()->can('developerOnly') || auth()->user()->can($module['route'])) --}}
                <li>
                    <a class="collapsible-header waves-effect waves-set {{ in_array($current_route_group, $module['routes']) ? 'active current' : '' }}" href="#">
                        <i class="material-icons">{{ $module['icon'] }}</i><span style="font-weight: 300;
                                            font-size: 13px;
                                            text-transform: uppercase;">@lang($module['name'])</span>
                        <i class="material-icons mdi-navigation-chevron-left">keyboard_arrow_left</i>
                    </a>
                    <div class="collapsible-body">
                      <ul>
                        @foreach ($module['items'] as $item)
                            @if (auth()->user()->can('developerOnly') || auth()->user()->can($module['route']) || auth()->user()->can($item['route']))
                                <li class="menu-item">
                                    <a class="waves-effect waves-set {{ $current_route_group == get_route_group($item['route']) ? 'active' : '' }}" href="{{ route($item['route']) }}">
                                        <span style="font-weight: 300;
                                            font-size: 13px;
                                            text-transform: uppercase;"
                                        >
                                            @lang($item['name'])
                                        </span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                        @foreach ($module['submodules'] as $submodule)
                            <li class="menu-item">
                                <ul class="collapsible">
                                    <li>
                                        <div class="collapsible-header {{ in_array($current_route_group, $submodule['routes']) ? 'active current' : '' }}">
                                             <span style="font-weight: 300;
                                            font-size: 13px;
                                            text-transform: uppercase;">
                                                @lang($submodule['name'])
                                            </span>
                                             <i class="material-icons mdi-navigation-chevron-left">keyboard_arrow_left</i>
                                        </div>
                                        <div class="collapsible-body">
                                            <ul>
                                                @foreach ($submodule['items'] as $item)
                                                    @if (auth()->user()->can('developerOnly') || auth()->user()->can($module['route']) || auth()->user()->can($item['route']))
                                                        <li class="menu-item" style="background-color: #212121;">
                                                            <a class="waves-effect waves-set {{ $current_route_group == get_route_group($item['route']) ? 'active' : '' }}" href="{{ route($item['route']) }}"><i class="material-icons">arrow_right</i>
                                                                <span style="font-weight: 300;
                                                                font-size: 13px;
                                                                text-transform: uppercase;">
                                                                    @lang($item['name'])
                                                                </span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        @endforeach
                      </ul>
                    </div>
                </li>
            {{-- @endif  --}}
        @endforeach

        <li>
            <a class="collapsible-header waves-effect waves-set {{ in_array($current_route_name,['admin.administrator.index','admin.roles.index','admin.permissions.index','admin.myrolepermission'])?'active current':'' }}" href="#">
                <i class="material-icons">security</i><span style="font-weight: 300;
                                                                font-size: 13px;
                                                                text-transform: uppercase;">@lang('view.menu.security')</span>
                <i class="material-icons mdi-navigation-chevron-left">keyboard_arrow_left</i>
            </a>
            <div class="collapsible-body">
              <ul>
                @if (auth()->user()->can('developerOnly') || auth()->user()->can('security') || auth()->user()->can('admin.list'))
                    <li class="menu-item">
                        <a class="waves-effect waves-set {{ $current_route_name=='admin.administrator.index' ? 'active' : '' }}" href="{{ url('/admin/administrator') }}"><span style="font-weight: 300;
                                                                font-size: 13px;
                                                                text-transform: uppercase;">@lang('view.menu.users')</span></a>
                    </li>
                @endif
                @if (auth()->user()->can('developerOnly') || auth()->user()->can('security') || auth()->user()->can('roles.list'))
                    <li class="menu-item">
                        <a class="waves-effect waves-set {{ $current_route_name=='admin.roles.index' ? 'active' : '' }}" href="{{ url('/admin/roles') }}"><span style="font-weight: 300;
                                                                font-size: 13px;
                                                                text-transform: uppercase;">@lang('view.menu.roles')</span></a>
                    </li>
                @endif
                @can('developerOnly')
                    <li class="menu-item">
                        <a class="waves-effect waves-set {{ $current_route_name=='admin.permissions.index' ? 'active' : '' }}" href="{{ url('/admin/permissions') }}"><span style="font-weight: 300;
                                                                font-size: 13px;
                                                                text-transform: uppercase;">@lang('view.menu.permissions')</span></a>
                    </li>
                @endcan
                @if (auth()->user()->can('developerOnly') || auth()->user()->can('security') || auth()->user()->can('permissions.assign'))
                    <li class="menu-item">
                        <a class="waves-effect waves-set {{ $current_route_name == 'admin.myrolepermission' ? 'active' : '' }}" href="{{ url('/admin/rolePermissions') }}">
                            <span style="font-weight: 300;
                                                                font-size: 13px;
                                                                text-transform: uppercase;">@lang('view.menu.assign_permissions')</span>
                        </a>
                    </li>
                @endif
                

                  
              </ul>
            </div>
        </li>

        @if (false && auth()->user()->can('developerOnly'))
            <li>
                <a class="collapsible-header waves-effect waves-set {{ in_array($current_route_name,['admin.user.index', 'admin.user.create', 'admin.user.store', 'admin.user.update', 'admin.user.edit'])?'active current':'' }}" href="#">
                    <i class="material-icons">group</i><span style="font-weight: 300;
                                            font-size: 13px;
                                            text-transform: uppercase;">@lang('view.menu.users')</span>
                    <i class="material-icons mdi-navigation-chevron-left">keyboard_arrow_left</i>
                </a>
                <div class="collapsible-body">
                  <ul>
                    <li class="menu-item">
                        <a class="waves-effect waves-set {{ $current_route_name=='admin.user.index'?'active':'' }}" href="{{ url('/admin/user') }}"><span style="font-weight: 300;
                                            font-size: 13px;
                                            text-transform: uppercase;">@lang('view.menu.list')</span></a>
                    </li>
                    <li class="menu-item">
                        <a class="waves-effect waves-set {{ $current_route_name=='admin.user.create'?'active':'' }}" href="{{ url('/admin/user/create') }}"><span style="font-weight: 300;
                                            font-size: 13px;
                                            text-transform: uppercase;">@lang('view.menu.add')</span></a>
                    </li>
                  </ul>
                </div>
            </li>
        @endif
    </ul>
</div>
