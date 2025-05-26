@extends("admin.admin_layout.default")
@section('breadcrumbs')
<li class="breadcrumb-item active">Permissions</li>
@endsection
@section('page-title')
Permissions
@endsection
@section('page-info')@endsection
@section('page-back-button')@endsection
@section('page-content')
<div class="page-content-width-full">
    
	@can("admin_permissions_access")
    <div class="content-layout content-width-medium admin-permissions-data-content js-ak-DataTable js-ak-delete-container js-ak-content-layout"
        data-id="admin_permissions"
        data-delete-modal-action="{{route("admin.admin_permissions.delete")}}">
        <div class="content-element">
            <div class="content-header">
                <div class="header">
                    <h3></h3>
                    <p class="info"></p>
                </div>
                <div class="action">
                    <div class="left">
                        <form class="search-container" ><input name="admin_permissions_source" value="admin_permissions" type="hidden"/><input name="admin_permissions_length" value="{{Request()->query("admin_permissions_length")}}" type="hidden"/>
                            <div class="search">
                                <input type="text" autocomplete="off" placeholder="{{trans('admin/table.search')}}" name="admin_permissions_search" value="{{(Request()->query("admin_permissions_source") == "admin_permissions")?Request()->query("admin_permissions_search")??"":""}}" class="form-input js-ak-search-input">
                                <button class="search-button" draggable="false">
                                    @includeIf("admin/admin_layout/partials/misc/icons/search_icon")
                                </button>
                                @if(Request()->query("admin_permissions_source") == "admin_permissions" && Request()->query("admin_permissions_search"))
                                    <div class="reset-search js-ak-reset-search">
                                        @includeIf("admin/admin_layout/partials/misc/icons/reset_search_icon")
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                    <div class="right">
                        @can('admin_permissions_delete')
                            <a href="" class="button danger-button js-ak-multi-delete-start" style="display: none" draggable="false">
                                @includeIf("admin/admin_layout/partials/misc/icons/delete_icon")
                                {{trans('admin/table.delete_button')}}
                            </a>
                        @endcan
                        @canany('admin_permissions_create')
                        <a href="{{route('admin.admin_permissions.create')}}" class="button primary-button add-new" draggable="false">
                            @includeIf("admin/admin_layout/partials/misc/icons/add_new_icon")
                            {{trans('admin/table.add_new')}}
                        </a>
                        @endcanany
                    </div>
                </div>
            </div>
        @php $duplicateSlugs = collect($admin_permissions_list_all)->pluck('permission_slug')->duplicates() @endphp
        @if($duplicateSlugs->count())
            <div class="error-message">
                {{trans('admin/misc.permission_duplicate_error_message')}}{{$duplicateSlugs->implode(', ')}}
            </div>
        @endIf
            <div class="content table-content">
                <table class="table js-ak-content">
                <thead>
                    <tr data-sort-method='thead'>
						<th>Title</th>
						<th>Permission slug</th>
                        @canany(['admin_permissions_edit','admin_permissions_delete'])
                        <th class="no-sort manage-th" data-orderable="false">
                            <div class="manage-links">
                                <div class="delete-select-all js-ak-toggle-delete-select">
                                    @includeIf("admin/admin_layout/partials/misc/icons/select_all")
                                </div>
                            </div>
                        </th>
                        @endcanany
                    </tr>
                </thead>
                <tbody class="">
                @forelse($admin_permissions_list_all as $data)
                    <tr>
						<td>
							{{$data->title}}
						</td>
						<td>
							{{$data->permission_slug}}
						</td>
                        @canany(['admin_permissions_edit','admin_permissions_delete'])
                        <td class="manage-td">
                            <div class="manage-links">
                                @can('admin_permissions_edit')
                                    <a href="{{route("admin.admin_permissions.edit", $data->id)}}" class="edit-link" draggable="false">@includeIf("admin/admin_layout/partials/misc/icons/edit_icon")</a>
                            @endcan
                                @can('admin_permissions_delete')
                                <label class="multi-delete-checkbox">
                                    <input type="checkbox" value="{{$data->id}}" class="form-checkbox js-ak-delete-select-me" data-id="multiple_delete_{{$data->id}}">
                                </label>
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
                        @can('admin_permissions_delete')
                            <a href="" class="button danger-button js-ak-multi-delete-start" style="display: none" draggable="false">
                                @includeIf("admin/admin_layout/partials/misc/icons/delete_icon")
                                {{trans('admin/table.delete_button')}}
                            </a>
                        @endcan
                </div>
            </div>
        </div>
    </div>
	@endcan

	
	@includeIf("admin.admin_layout.partials.delete_modal_confirm")
</div>
@endsection