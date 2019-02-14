@extends('admin.layout.default')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatable/jquery.dataTables.min.css') }}">
@endsection

@section('jsPostApp')
    <script src="{{ asset('plugins/datatable/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#dashboard-permisionlist').DataTable({
                pagingType: "simple",
                pageLength: 4,
                language: {
                    paginate: {'next': 'Next &rarr;', 'previous': '&larr; Prev'}
                }
            });
        } );
    </script>
@endsection

@section('content')
<div class="main-container">
    <div class="row">
        <div class="col s12 m6">
            <div class="card horizontal">
                <div class="card-image valign-wrapper pad-lr-20">
                    <i class="material-icons medium valign primary-text">supervisor_account</i>
                </div>
                <div class="card-stacked">
                    <div class="card-content right-align">
                        <div class="card-title" style="font-weight:bold;">{{ $data->adminCount }}</div>
                        <p>Administrators</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m6">
            <div class="card horizontal">
                <div class="card-image valign-wrapper pad-lr-20">
                    <i class="material-icons medium valign secondary-text">person</i>
                </div>
                <div class="card-stacked">
                    <div class="card-content right-align">
                        <div class="card-title" style="font-weight:bold;">{{ $data->usersCount }}</div>
                        <p>Users</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m6">
            <div class="card horizontal">
                <div class="card-image valign-wrapper pad-lr-20">
                    <i class="material-icons medium valign warning-text">accessibility</i>
                </div>
                <div class="card-stacked">
                    <div class="card-content right-align">
                        <div class="card-title" style="font-weight:bold;">{{$data->roleCount}}</div>
                        <p>Total Roles</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m6">
            <div class="card horizontal">
                <div class="card-image valign-wrapper pad-lr-20">
                    <i class="material-icons medium valign success-text">fingerprint</i>
                </div>
                <div class="card-stacked">
                    <div class="card-content right-align">
                        <div class="card-title" style="font-weight:bold;">{{$data->permissionCount}}</div>
                        <p>Total Permissions</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Tables --}}
    <div class="row">
        <div class="col s12 l6">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Permissions</span>
                    @if ($data->permissions->count() > 0)
                        <div class="datatable-wrapper">
                            <table cellspacing="0" width="100%"
                                class="datatable-badges display cell-border dataTable"
                                id="dashboard-permisionlist">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Created On</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->permissions as $permission)
                                        <tr>
                                            <td>{{ $permission->label }}</td>
                                            <td>{{ Carbon\Carbon::parse($permission->created_at)->format('d-m-Y H:i:s') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <th>Name</th>
                                    <th>Created On</th>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <p>No Records to show for permissions</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col s12 m12 l6">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Roles</span>
                    @if ($data->roles->count() > 0)
                        <table class="responsive-table">
                            <thead class="primary-text">
                                <tr>
                                    <th data-field="id">ID</th>
                                    <th data-field="name">Name</th>
                                    <th data-field="data">Created On</th>
                                </tr>
                            </thead>
                            <tbody class="black-text">
                                @foreach ($data->roles as $role)
                                    <tr>
                                        <td>#{{ $role->id }}</td>
                                        <td>{{ ucwords($role->name) }}</td>
                                        <td>{{ Carbon\Carbon::parse($role->created_at)->format('d-m-Y H:i:s') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No Records to show for Roles</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
