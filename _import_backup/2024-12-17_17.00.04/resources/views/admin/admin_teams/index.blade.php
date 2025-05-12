@extends("admin.admin_layout.default")
@section('breadcrumbs')
<li class="breadcrumb-item active">Teams</li>
@endsection
@section('page-title')
Teams
@endsection
@section('page-info')@endsection
@section('page-back-button')@endsection
@section('page-content')
<div class="page-content-width-full">
    
	@can("admin_teams_access")
    <div class="content-layout content-width-medium admin-teams-data-content js-ak-DataTable js-ak-delete-container js-ak-content-layout"
        data-id="admin_teams"
        data-delete-modal-action="{{route("admin.admin_teams.delete")}}">
        <div class="content-element">
            <div class="content-header">
                <div class="header">
                    <h3></h3>
                    <p class="info"></p>
                </div>
                <div class="action">
                    <div class="left">
                        <form class="search-container" ><input name="admin_teams_source" value="admin_teams" type="hidden"/><input name="admin_teams_length" value="{{Request()->query("admin_teams_length")}}" type="hidden"/>
                            <div class="search">
                                <input type="text" autocomplete="off" placeholder="{{trans('admin/table.search')}}" name="admin_teams_search" value="{{(Request()->query("admin_teams_source") == "admin_teams")?Request()->query("admin_teams_search")??"":""}}" class="form-input js-ak-search-input">
                                <button class="search-button" draggable="false">
                                    @includeIf("admin/admin_layout/partials/misc/icons/search_icon")
                                </button>
                                @if(Request()->query("admin_teams_source") == "admin_teams" && Request()->query("admin_teams_search"))
                                    <div class="reset-search js-ak-reset-search">
                                        @includeIf("admin/admin_layout/partials/misc/icons/reset_search_icon")
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                    <div class="right">
                        @canany('admin_teams_create')
                        <a href="{{route('admin.admin_teams.create')}}" class="button primary-button add-new" draggable="false">
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
						<th>Name</th>
                        @canany(['admin_teams_edit','admin_teams_show','admin_teams_delete'])
                        <th class="no-sort manage-th" data-orderable="false">
                            <div class="manage-links">
                                
                            </div>
                        </th>
                        @endcanany
                    </tr>
                </thead>
                <tbody class="">
                @forelse($admin_teams_list_all as $data)
                    <tr>
						<td>
							{{$data->name}}
						</td>
                        @canany(['admin_teams_edit','admin_teams_show','admin_teams_delete'])
                        <td class="manage-td">
                            <div class="manage-links">
                                @can('admin_teams_edit')
                                    <a href="{{route("admin.admin_teams.edit", $data->id)}}" class="edit-link" draggable="false">@includeIf("admin/admin_layout/partials/misc/icons/edit_icon")</a>
                            @endcan
                                @can('admin_teams_show')
                                <a href="{{route("admin.admin_teams.show", $data->id)}}" draggable="false" class="show-link">
                                    @includeIf("admin/admin_layout/partials/misc/icons/show_icon")
                                </a>
                                @endcan
                                @can('admin_teams_delete')
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