@extends("admin.admin_layout.default")
@section('breadcrumbs')
<li class="breadcrumb-item active">Users</li>
@endsection
@section('page-title')
Users
@endsection
@section('page-info')@endsection
@section('page-back-button')@endsection
@section('page-content')
<div class="page-content-width-full">
    
	@can("admin_users_access")
    <div class="content-layout content-width-medium admin-users-data-content js-ak-DataTable js-ak-delete-container js-ak-content-layout"
        data-id="admin_users"
        data-delete-modal-action="{{route("admin.admin_users.delete")}}">
        <div class="content-element">
            <div class="content-header">
                <div class="header">
                    <h3></h3>
                    <p class="info"></p>
                </div>
                <div class="action">
                    <div class="left">
                        <form class="search-container" ><input name="admin_users_source" value="admin_users" type="hidden"/><input name="admin_users_length" value="{{Request()->query("admin_users_length")}}" type="hidden"/>
                            <div class="search">
                                <input type="text" autocomplete="off" placeholder="{{trans('admin/table.search')}}" name="admin_users_search" value="{{(Request()->query("admin_users_source") == "admin_users")?Request()->query("admin_users_search")??"":""}}" class="form-input js-ak-search-input">
                                <button class="search-button" draggable="false">
                                    @includeIf("admin/admin_layout/partials/misc/icons/search_icon")
                                </button>
                                @if(Request()->query("admin_users_source") == "admin_users" && Request()->query("admin_users_search"))
                                    <div class="reset-search js-ak-reset-search">
                                        @includeIf("admin/admin_layout/partials/misc/icons/reset_search_icon")
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                    <div class="right">
                        @canany('admin_users_create')
                        <a href="{{route('admin.admin_users.create')}}" class="button primary-button add-new" draggable="false">
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
						<th>Image</th>
						<th>Name</th>
						<th>Roles</th>
						<th class="center-text table-col-hide-sm" data-sort-method="number">Active</th>
						<th class="text-nowrap table-col-hide-sm">Team</th>
                        @canany(['admin_users_edit','admin_users_delete'])
                        <th class="no-sort manage-th" data-orderable="false">
                            <div class="manage-links">
                                
                            </div>
                        </th>
                        @endcanany
                    </tr>
                </thead>
                <tbody class="">
                @forelse($admin_users_list_all as $data)
                    <tr>
						<td class="image-col">
							@if ($data->image)
                                <a href="{{ $data->image }}"  class="item-image lightbox js-base64-image-preview">
                                    <div style="background-image: url('{{ $data->image }}')"></div>
                                </a>
                            @endIf
						</td>
						<td>
							{{$data->name}} <br> @if ($data->email)<a href="mailto:{{$data->email}}">{{$data->email}}</a>@endIf
						</td>
						<td>
							
							<div class="small-badge">
                            @foreach($data->rolesMany->take(10) as $row)
								<div>
									{{$row->title}}
								</div>
							@endforeach
                            @if($data->rolesMany->count() > 10) ... @endif
                            </div>
						
						</td>
						<td class="center-text table-col-hide-sm">
							<span class="checkbox-status {{$data->active == 1?"bg-success":""}}"></span>
						</td>
						<td class="text-nowrap table-col-hide-sm">
							
							@if($data->teamIdToValue->name??false){{($data->teamIdToValue->name)}} @endif
						
						</td>
                        @canany(['admin_users_edit','admin_users_delete'])
                        <td class="manage-td">
                            <div class="manage-links">
                                @can('admin_users_edit')
                                    <a href="{{route("admin.admin_users.edit", $data->id)}}" class="edit-link" draggable="false">@includeIf("admin/admin_layout/partials/misc/icons/edit_icon")</a>
                            @endcan
                                @can('admin_users_delete')
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