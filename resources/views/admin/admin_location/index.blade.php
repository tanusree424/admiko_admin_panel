@extends("admin.admin_layout.default")

@section('breadcrumbs')
    <li class="breadcrumb-item active">Locations</li>
@endsection

@section('page-title')
    Location Master
@endsection

@section('page-info')
@endsection

@section('page-back-button')
@endsection

@section('page-content')
<div class="page-content-width-full">

    @can("locations_access")
    @fragment("locations_fragment") {{-- Fixed from brands_fragment --}}
    <div class="content-layout content-width-full locations-data-content js-ak-DataTable js-ak-ajax-DataTable-container js-ak-content-layout"
        data-id="locations"
        data-ajax-call-url="{{ route('admin.location.index') }}"
        data-delete-modal-action="{{ route('admin.location.delete') }}">

        <div class="content-element">
            <div class="content-header">
                <div class="header">
                    <h3></h3>
                    <p class="info"></p>
                </div>

                <div class="action">
                    <div class="left">
                        <form class="search-container js-ak-ajax-search">
                            <input name="location_source" value="location" type="hidden" />
                            <input name="location_length" value="{{ request()->query('location_length') }}" type="hidden" />
                            <div class="search">
                                <input type="text" autocomplete="off" placeholder="{{ trans('admin/table.search') }}"
                                    name="location_search"
                                    value="{{ request()->query('location_search') ?? '' }}"
                                    class="form-input js-ak-search-input" />

                                <button class="search-button" draggable="false">
                                    @includeIf("admin/admin_layout/partials/misc/icons/search_icon")
                                </button>

                                @if(request()->query("location_source") == "location" && request()->query("location_search"))
                                    <div class="reset-search js-ak-reset-search">
                                        @includeIf("admin/admin_layout/partials/misc/icons/reset_search_icon")
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>

                    <div class="right">
                        @can('locations_create')
                            <a href="{{ route('admin.location.create') }}"
                               class="button primary-button add-new" draggable="false">
                                @includeIf("admin/admin_layout/partials/misc/icons/add_new_icon")
                                {{ trans('admin/table.add_new') }}
                            </a>
                        @endcan
                    </div>
                </div>
            </div>

            <div class="content table-content">
                <div class="ajax-spinner js-ak-ajax-spinner">
                    <div class="ajax-spinner-action">
                        @includeIf("admin.admin_layout/partials/misc/loading")
                    </div>
                </div>

                <table class="table js-ak-content js-ak-ajax-content">
                    <thead>
                        <tr data-sort-method='thead'>
                            <th class="table-id" data-sort-method="number">ID</th>
                            <th>Country Name</th>
                            <th>Location</th>
                            <th>Region</th>
                            <th class="table-col-hide-sm">Created Time</th>
                            @canany(['locations_edit','locations_delete'])
                                <th class="no-sort manage-th" data-orderable="false">
                                    <div class="manage-links"></div>
                                </th>
                            @endcanany
                        </tr>
                    </thead>

                    <tbody>
                         @php
                            $id = 1;
                        @endphp
                        @forelse($locations_list_all as $data)

                            <tr>
                                <td>{{ $id++ }}</td>
                                <td>{{ $data->country_name }}</td>
                                <td>{{ $data->location_name }}</td> {{-- Assumes the DB column is location_name --}}
                                <td>{{ $data->region }}</td>
                                <td class="table-col-hide-sm">{{ $data->created_at }}</td>
                                @canany(['locations_edit','locations_delete'])
                                    <td class="manage-td">
                                        <div class="manage-links">
                                            @can('locations_edit')
                                                <a href="{{ route('admin.location.edit', $data->id) }}"
                                                   class="edit-link" draggable="false">
                                                    @includeIf("admin/admin_layout/partials/misc/icons/edit_icon")
                                                </a>
                                            @endcan

                                            @can('locations_delete')
                                                <a href="#"
                                                   data-id="{{ $data->id }}"
                                                   class="delete-link js-ak-delete-link" draggable="false">
                                                    @includeIf("admin/admin_layout/partials/misc/icons/delete_icon")
                                                </a>
                                            @endcan
                                        </div>
                                    </td>
                                @endcanany
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">{{ trans('admin/table.no_records_found') }}</td>
                            </tr>
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

        @includeIf("admin.admin_layout.partials.delete_modal_confirm_ajax")

    </div>
    @endfragment
    @endcan

    @includeIf("admin.admin_layout.partials.delete_modal_confirm")
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Then load DataTables (and any other jQuery plugins) -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>

$(document).ready(function() {
    const table = $('.js-ak-ajax-content').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("admin.location.index") }}',
            data: function (d) {
                d.location_search = $('input[name=location_search]').val();
                d.location_source = 'location';
                // Add more parameters here if needed
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'country.name', name: 'country.name' }, // Assuming relation 'country'
            { data: 'location_name', name: 'location_name' },
            { data: 'region', name: 'region' },
            { data: 'created_at', name: 'created_at' },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false
            }
        ]
    });

    // Optional: refresh table on form submit (custom search)
    $('.js-ak-ajax-search').on('submit', function(e) {
        e.preventDefault();
        table.ajax.reload();
    });

    // Optional: reset search
    $('.js-ak-reset-search').on('click', function () {
        $('input[name=location_search]').val('');
        table.ajax.reload();
    });
    // delete Item
    $(document).on('click', '.js-ak-delete-link', function (e) {
    e.preventDefault();

    const deleteId = $(this).data('id');
    if (!confirm("Are you sure you want to delete this item?")) return;

    $.ajax({
        url: '{{ route("admin.location.delete") }}',
        type: 'POST',
        data: {
            _method: 'DELETE',
            _token: '{{ csrf_token() }}',
            delete_id: deleteId
        },
        success: function (response) {
            location.reload(); // or remove row from table
        },
        error: function (xhr) {
            alert("Error: " + xhr.responseText);
        }
    });
});

});
</script>

@endsection
