@extends("admin.admin_layout.default")
@section('breadcrumbs')
	<li class="breadcrumb-item"><a href="{{ route("admin.admin_teams.index") }}">Teams</a></li>
    
    <li class="breadcrumb-item active">{{trans('admin/misc.breadcrumbs_show')}}</li>
@endsection
@section('page-title')
Teams
@endsection
@section('page-info')@endsection
@section('page-back-button'){{ route("admin.admin_teams.index") }}@endsection
@section('page-content')
<div class="show-container content-width-medium admin-teams-show js-ak-show-container">
    <div class="show-header">
        <div class="print-btn js-ak-show-content-print">
            @includeIf("admin/admin_layout/partials/misc/icons/print_icon")
        </div>
    </div>
    
    <div class="show-content show-content-print" id="js-ak-show-content-print">
        
            <div class="row-100" id="name_show">
                <div class="show-data-container">
                    <div class="show-label">
                        <label class="">Name</label>
                    </div>
                    <div class="show-data text-break">
                        {{ strip_tags($data->name??"") }}
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection