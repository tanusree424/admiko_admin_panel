    <div class="content-layout content-width-full purchase-orders-data-content js-ak-ajax-container js-ak-content-layout"
        data-id="purchase_orders"
		data-ajax-call-url="{{route("admin.po_distributors_view.purchase_orders.index")}}"
        data-delete-modal-action="{{route("admin.po_distributors_view.purchase_orders.delete")}}">
        <div class="content-element">
            <div class="content-header">
                <div class="header">
                    <h3>Purchase Orders</h3>
                    <p class="info"></p>
                </div>
                <div class="action">
                    <div class="left">
                        <form class="search-container js-ak-ajax-search" ><input name="purchase_orders_source" value="purchase_orders" type="hidden"/><input name="purchase_orders_length" value="{{Request()->query("purchase_orders_length")}}" type="hidden"/>
                            <div class="search">
                                <input type="text" autocomplete="off" placeholder="{{trans('admin/table.search')}}" name="purchase_orders_search" value="{{(Request()->query("purchase_orders_source") == "purchase_orders")?Request()->query("purchase_orders_search")??"":""}}" class="form-input js-ak-search-input">
                                <button class="search-button" draggable="false">
                                    @includeIf("admin/admin_layout/partials/misc/icons/search_icon")
                                </button>
                                @if(Request()->query("purchase_orders_source") == "purchase_orders" && Request()->query("purchase_orders_search"))
                                    <div class="reset-search js-ak-reset-search">
                                        @includeIf("admin/admin_layout/partials/misc/icons/reset_search_icon")
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                    <div class="right">
                        @canany('po_distributors_view.purchase_orders_create')
                        <a href="{{route('admin.po_distributors_view.purchase_orders.create')}}" class="button primary-button add-new" draggable="false">
                            @includeIf("admin/admin_layout/partials/misc/icons/add_new_icon")
                            {{trans('admin/table.add_new')}}
                        </a>
                        @endcanany
                    </div>
                </div>
            </div>
            <div class="content table-content">
                <div class="ajax-spinner js-ak-ajax-spinner">
                    <div class="ajax-spinner-action">
                        @includeIf("admin.admin_layout/partials/misc/loading")
                    </div>
                </div>
                <table class="table js-ak-content sort-header">
                <thead>
                    <tr data-sort-method='thead'>
						<th class="table-id">
                            @php
                                $direction = (Request()->query('purchase_orders_source') == 'purchase_orders' && Request()->query('purchase_orders_sort_by') == 'id' && Request()->query('purchase_orders_direction') == 'asc')?"desc":"asc"
                            @endphp
                            <a class="{{(Request()->query('purchase_orders_sort_by') == 'id')?$direction:''}} js-ak-th-sort" href="?purchase_orders_sort_by=id&purchase_orders_direction={{$direction}}&{{$purchase_orders_list_all->table_action['header_query']}}" draggable="false">ID</a>
						</th>
                        @canany(['po_distributors_view.purchase_orders_edit','po_distributors_view.purchase_orders_delete'])
                        <th class="no-sort manage-th" data-orderable="false">
                            <div class="manage-links">

                            </div>
                        </th>
                        @endcanany
                    </tr>
                </thead>
                <tbody class=" js-ak-ajax-content">
                @forelse($purchase_orders_list_all as $data)
                    <tr>
						<td>
							{{$data->id}}
						</td>
                        @canany(['po_distributors_view.purchase_orders_edit','po_distributors_view.purchase_orders_delete'])
                        <td class="manage-td">
                            <div class="manage-links">
                                @can('po_distributors_view.purchase_orders_edit')
                                    <a href="{{route("admin.po_distributors_view.purchase_orders.edit", $data->id)}}" class="edit-link" draggable="false">@includeIf("admin/admin_layout/partials/misc/icons/edit_icon")</a>
                            @endcan
                                @can('po_distributors_view.purchase_orders_delete')
                                <a href="#" data-id="{{$data->id}}" class="delete-link js-ak-delete-link" draggable="false">@includeIf("admin/admin_layout/partials/misc/icons/delete_icon")</a>
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
                    <select class="form-select js-ak-ajax-length">
                        @foreach(config("admin.table.table_length") as $key => $value)
                        <option value="?purchase_orders_length={{$key}}&{{$purchase_orders_list_all->table_action['length_query']}}" @if(Request()->purchase_orders_length == $key) selected @endif>{{$value}}</option>
                        @endforeach
                    </select>
                </div>

                </div>
                <div class="right">
                    <div class="content-pagination js-ak-ajax-pagination">
                        {{ $purchase_orders_list_all->withQueryString()->onEachSide(2)->links("admin.admin_layout.partials.table.paginate") }}
                    </div>
                </div>
            </div>
        </div>
	<input type="hidden" class="js-ak-ajax-active-query" value="{{$purchase_orders_list_all->table_action["full_query"]}}">
	@includeIf("admin.admin_layout.partials.delete_modal_confirm_ajax")
    </div>
