@extends("admin.admin_layout.default")
@section('breadcrumbs')
	<li class="breadcrumb-item"><a href="{{ route("admin.admin_auditable_logs.index") }}">Auditable Logs</a></li>
    
    <li class="breadcrumb-item active">{{trans('admin/misc.breadcrumbs_show')}}</li>
@endsection
@section('page-title')
Auditable logs
@endsection
@section('page-info')@endsection
@section('page-back-button'){{ route("admin.admin_auditable_logs.index") }}@endsection
@section('page-content')
<div class="show-container content-width-medium admin-auditable-logs-show js-ak-show-container">
    <div class="show-header">
        <div class="print-btn js-ak-show-content-print">
            @includeIf("admin/admin_layout/partials/misc/icons/print_icon")
        </div>
    </div>
    
    <div class="show-content show-content-print" id="js-ak-show-content-print">
        
            <div class="row-100" id="action_show">
                <div class="show-data-container">
                    <div class="show-label">
                        <label class="">Action</label>
                    </div>
                    <div class="show-data text-break">
                        {{ strip_tags($data->action??"") }}
                    </div>
                </div>
            </div>
            <div class="row-100" id="user_id_show">
                <div class="show-data-container">
                    <div class="show-label">
                        <label class="">User</label>
                    </div>
                    <div class="show-data text-break">
                         @if($data->userIdToValue->name??false){{($data->userIdToValue->name)}} @endif
                    </div>
                </div>
            </div>
            <div class="row-100" id="model_show">
                <div class="show-data-container">
                    <div class="show-label">
                        <label class="">Model</label>
                    </div>
                    <div class="show-data text-break">
                        {{ strip_tags($data->model??"") }}
                    </div>
                </div>
            </div>
            <div class="row-100" id="row_id_show">
                <div class="show-data-container">
                    <div class="show-label">
                        <label class="">Row ID</label>
                    </div>
                    <div class="show-data text-break">
                        {{ strip_tags($data->row_id??"") }}
                    </div>
                </div>
            </div>
            <div class="row-100" id="properties_old_show">
                <div class="show-data-container">
                    <div class="show-label">
                        <label class="">Properties old</label>
                    </div>
                    <div class="show-data text-break">
                        {{ strip_tags($data->properties_old??"") }}
                    </div>
                </div>
            </div>
            <div class="row-100" id="properties_new_show">
                <div class="show-data-container">
                    <div class="show-label">
                        <label class="">Properties new</label>
                    </div>
                    <div class="show-data text-break">
                        {{ strip_tags($data->properties_new??"") }}
                    </div>
                </div>
            </div>
            <div class="row-100" id="url_show">
                <div class="show-data-container">
                    <div class="show-label">
                        <label class="">Url</label>
                    </div>
                    <div class="show-data text-break">
                        {{ strip_tags($data->url??"") }}
                    </div>
                </div>
            </div>
            <div class="row-100" id="ip_show">
                <div class="show-data-container">
                    <div class="show-label">
                        <label class="">IP</label>
                    </div>
                    <div class="show-data text-break">
                        {{ strip_tags($data->ip??"") }}
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection