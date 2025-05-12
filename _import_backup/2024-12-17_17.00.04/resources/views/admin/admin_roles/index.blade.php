@extends("admin.admin_layout.default")
@section('breadcrumbs')
<li class="breadcrumb-item active">Roles</li>
@endsection
@section('page-title')
Roles
@endsection
@section('page-info')@endsection
@section('page-back-button')@endsection
@section('page-content')
<div class="page-content-width-full">
    
	@can("admin_roles_access")
    <div class="content-layout content-width-medium admin-roles-data-content js-ak-DataTable js-ak-delete-container js-ak-content-layout"
        data-id="admin_roles"
        data-delete-modal-action="{{route("admin.admin_roles.delete")}}">
        <div class="content-element">
            <div class="content-header">
                <div class="header">
                    <h3></h3>
                    <p class="info"></p>
                </div>
                <div class="action">
                    <div class="left">
                        <form class="search-container" ><input name="admin_roles_source" value="admin_roles" type="hidden"/><input name="admin_roles_length" value="{{Request()->query("admin_roles_length")}}" type="hidden"/>
                            <div class="search">
                                <input type="text" autocomplete="off" placeholder="{{trans('admin/table.search')}}" name="admin_roles_search" value="{{(Request()->query("admin_roles_source") == "admin_roles")?Request()->query("admin_roles_search")??"":""}}" class="form-input js-ak-search-input">
                                <button class="search-button" draggable="false">
                                    @includeIf("admin/admin_layout/partials/misc/icons/search_icon")
                                </button>
                                @if(Request()->query("admin_roles_source") == "admin_roles" && Request()->query("admin_roles_search"))
                                    <div class="reset-search js-ak-reset-search">
                                        @includeIf("admin/admin_layout/partials/misc/icons/reset_search_icon")
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                    <div class="right">
                        @canany('admin_roles_create')
                        <a href="{{route('admin.admin_roles.create')}}" class="button primary-button add-new" draggable="false">
                            @includeIf("admin/admin_layout/partials/misc/icons/add_new_icon")
                            {{trans('admin/table.add_new')}}
                        </a>
                        @endcanany
                    </div>
                </div>
            </div>
            <div class="content table-content">
                <table class="table js-ak-content">
                <thead>
                    <tr data-sort-method='thead'>
						<th>Title</th>
						<th>Users</th>
						<th>Permissions</th>
                        @canany(['admin_roles_edit','admin_roles_delete'])
                        <th class="no-sort manage-th" data-orderable="false">
                            <div class="manage-links">
                                
                            </div>
                        </th>
                        @endcanany
                    </tr>
                </thead>
                <tbody class="">
                @forelse($admin_roles_list_all as $data)
                    <tr>
						<td>
							{{$data->title}}
						</td>
						<td>
							
							<div class="small-badge">
                            @foreach($data->usersMany->take(10) as $row)
								<div>
									{{$row->name}}
								</div>
							@endforeach
                            @if($data->usersMany->count() > 10) ... @endif
                            </div>
						
						</td>
						<td>
							
							<div class="small-badge">
                            @foreach($data->permissionsMany->take(10) as $row)
								<div>
									{{$row->permission_slug}}
								</div>
							@endforeach
                            @if($data->permissionsMany->count() > 10) ... @endif
                            </div>
						
						</td>
                        @canany(['admin_roles_edit','admin_roles_delete'])
                        <td class="manage-td">
                            <div class="manage-links">
                                @can('admin_roles_edit')
                                    <a href="{{route("admin.admin_roles.edit", $data->id)}}" class="edit-link" draggable="false">@includeIf("admin/admin_layout/partials/misc/icons/edit_icon")</a>
                            @endcan
                                @can('admin_roles_delete')
                                <a href="#" data-id="{{$data->id}}" class="delete-link js-ak-delete-link" draggable="false">@includeIf("admin/admin_layout/partials/misc/icons/delete_icon")</a>
                                @endcan
                            </div>
                        </td>
                        @endcanany
                    </tr>
                @empty
                    
                @endforelse
                </tbody>
            </table>
            </div>
            <div class="content-footer">
                <div class="left">
                    <div class="change-length js-ak-table-length-DataTable"></div>
                </div>
                <div class="right">
                    <div class="content-pagination">
                        <nav class="pagination-container">
                            <div class="pagination-content">
                                <div class="pagination-info js-ak-pagination-info"></div>
                                <div class="pagination-box-data-table js-ak-pagination-box"></div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
	@endcan

	
	@includeIf("admin.admin_layout.partials.delete_modal_confirm")
</div>
@endsection