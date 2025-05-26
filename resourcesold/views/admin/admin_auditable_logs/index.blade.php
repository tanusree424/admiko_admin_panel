@extends("admin.admin_layout.default")
@section('breadcrumbs')
<li class="breadcrumb-item active">Auditable Logs</li>
@endsection
@section('page-title')
Auditable logs
@endsection
@section('page-info')@endsection
@section('page-back-button')@endsection
@section('page-content')
<div class="page-content-width-full">
    
	@can("admin_auditable_logs_access")
    <div class="content-layout content-width-medium admin-auditable-logs-data-content js-ak-delete-container js-ak-content-layout"
        data-id="admin_auditable_logs"
        data-delete-modal-action="{{route("admin.admin_auditable_logs.delete")}}">
        <div class="content-element">
            <div class="content-header">
                <div class="header">
                    <h3></h3>
                    <p class="info"></p>
                </div>
                <div class="action">
                    <div class="left">
                        <form class="search-container" ><input name="admin_auditable_logs_source" value="admin_auditable_logs" type="hidden"/><input name="admin_auditable_logs_length" value="{{Request()->query("admin_auditable_logs_length")}}" type="hidden"/>
                            <div class="search">
                                <input type="text" autocomplete="off" placeholder="{{trans('admin/table.search')}}" name="admin_auditable_logs_search" value="{{(Request()->query("admin_auditable_logs_source") == "admin_auditable_logs")?Request()->query("admin_auditable_logs_search")??"":""}}" class="form-input js-ak-search-input">
                                <button class="search-button" draggable="false">
                                    @includeIf("admin/admin_layout/partials/misc/icons/search_icon")
                                </button>
                                @if(Request()->query("admin_auditable_logs_source") == "admin_auditable_logs" && Request()->query("admin_auditable_logs_search"))
                                    <div class="reset-search js-ak-reset-search">
                                        @includeIf("admin/admin_layout/partials/misc/icons/reset_search_icon")
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                    <div class="right">
                        
                    </div>
                </div>
            </div>
            <div class="content table-content">
                <table class="table js-ak-content sort-header">
                <thead>
                    <tr data-sort-method='thead'>
						<th>
                            @php
                                $direction = (Request()->query('admin_auditable_logs_source') == 'admin_auditable_logs' && Request()->query('admin_auditable_logs_sort_by') == 'action' && Request()->query('admin_auditable_logs_direction') == 'asc')?"desc":"asc"
                            @endphp
                            <a class="{{(Request()->query('admin_auditable_logs_sort_by') == 'action')?$direction:''}} js-ak-th-sort" href="?admin_auditable_logs_sort_by=action&admin_auditable_logs_direction={{$direction}}&{{$admin_auditable_logs_list_all->table_action['header_query']}}" draggable="false">Action</a>
						</th>
						<th class="text-nowrap">
                            @php
                                $direction = (Request()->query('admin_auditable_logs_source') == 'admin_auditable_logs' && Request()->query('admin_auditable_logs_sort_by') == 'user_id' && Request()->query('admin_auditable_logs_direction') == 'asc')?"desc":"asc"
                            @endphp
                            <a class="{{(Request()->query('admin_auditable_logs_sort_by') == 'user_id')?$direction:''}} js-ak-th-sort" href="?admin_auditable_logs_sort_by=user_id&admin_auditable_logs_direction={{$direction}}&{{$admin_auditable_logs_list_all->table_action['header_query']}}" draggable="false">User</a>
						</th>
						<th>
                            @php
                                $direction = (Request()->query('admin_auditable_logs_source') == 'admin_auditable_logs' && Request()->query('admin_auditable_logs_sort_by') == 'url' && Request()->query('admin_auditable_logs_direction') == 'asc')?"desc":"asc"
                            @endphp
                            <a class="{{(Request()->query('admin_auditable_logs_sort_by') == 'url')?$direction:''}} js-ak-th-sort" href="?admin_auditable_logs_sort_by=url&admin_auditable_logs_direction={{$direction}}&{{$admin_auditable_logs_list_all->table_action['header_query']}}" draggable="false">Url</a>
						</th>
						<th class=" table-col-hide-sm">
                            @php
                                $direction = (Request()->query('admin_auditable_logs_source') == 'admin_auditable_logs' && Request()->query('admin_auditable_logs_sort_by') == 'ip' && Request()->query('admin_auditable_logs_direction') == 'asc')?"desc":"asc"
                            @endphp
                            <a class="{{(Request()->query('admin_auditable_logs_sort_by') == 'ip')?$direction:''}} js-ak-th-sort" href="?admin_auditable_logs_sort_by=ip&admin_auditable_logs_direction={{$direction}}&{{$admin_auditable_logs_list_all->table_action['header_query']}}" draggable="false">IP</a>
						</th>
						<th class="center-text table-col-hide-sm">
                            @php
                                $direction = (Request()->query('admin_auditable_logs_source') == 'admin_auditable_logs' && Request()->query('admin_auditable_logs_sort_by') == 'created_at' && Request()->query('admin_auditable_logs_direction') == 'asc')?"desc":"asc"
                            @endphp
                            <a class="{{(Request()->query('admin_auditable_logs_sort_by') == 'created_at')?$direction:''}} js-ak-th-sort" href="?admin_auditable_logs_sort_by=created_at&admin_auditable_logs_direction={{$direction}}&{{$admin_auditable_logs_list_all->table_action['header_query']}}" draggable="false">Created at</a>
						</th>
                        @canany(['admin_auditable_logs_show'])
                        <th class="no-sort manage-th" data-orderable="false">
                            <div class="manage-links">
                                
                            </div>
                        </th>
                        @endcanany
                    </tr>
                </thead>
                <tbody class="">
                @forelse($admin_auditable_logs_list_all as $data)
                    <tr>
						<td>
							{{$data->action}}
						</td>
						<td class="text-nowrap">
							
							@if($data->userIdToValue->name??false){{($data->userIdToValue->name)}} @endif
						
						</td>
						<td>
							{{$data->url}}
						</td>
						<td class=" table-col-hide-sm">
							{{$data->ip}}
						</td>
						<td class="text-nowrap center-text table-col-hide-sm">
							{{$data->created_at?->translatedFormat(trans("admin/config/date_time.php_date_time_format"))}}
						</td>
                        @canany(['admin_auditable_logs_show'])
                        <td class="manage-td">
                            <div class="manage-links">
                                
                                @can('admin_auditable_logs_show')
                                <a href="{{route("admin.admin_auditable_logs.show", $data->id)}}" draggable="false" class="show-link">
                                    @includeIf("admin/admin_layout/partials/misc/icons/show_icon")
                                </a>
                                @endcan
                                
                            </div>
                        </td>
                        @endcanany
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%">{{trans('admin/table.table_empty')}}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            </div>
            <div class="content-footer">
                <div class="left">
                    <div class="change-length">
                    <select class="form-select js-ak-table-length">
                        @foreach(config("admin.table.table_length") as $key => $value)
                        <option value="?admin_auditable_logs_length={{$key}}&{{$admin_auditable_logs_list_all->table_action['length_query']}}" @if(Request()->admin_auditable_logs_length == $key) selected @endif>{{$value}}</option>
                        @endforeach
                    </select>
                </div>
				
                </div>
                <div class="right">
                    <div class="content-pagination">
                        {{ $admin_auditable_logs_list_all->withQueryString()->onEachSide(2)->links("admin.admin_layout.partials.table.paginate") }}
                    </div>
                </div>
            </div>
        </div>
    </div>
	@endcan

	
	@includeIf("admin.admin_layout.partials.delete_modal_confirm")
</div>
@endsection