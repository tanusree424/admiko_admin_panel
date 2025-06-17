<?php
// app/Http/Controllers/LocationController.php

namespace App\Http\Controllers\Admin\AdminLocation;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Admin\AdminLocation\Location;
use App\Models\Admin\Countries\Countries;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;


class LocationController extends Controller
{
    public array $menu = ["item" =>"locations_access", "folder" =>"", "subfolder" =>""];

public function index(Request $request)
{
    if (Gate::none(['locations_access'])) {
        abort(403);
    }

    // Handle AJAX request for DataTables
    if ($request->ajax()) {
        $query = Location::with('country')->select('locations.*'); // Use correct table name

        if ($search = $request->get('location_search')) {
            $query->where(function ($q) use ($search) {
                $q->where('location_name', 'like', "%{$search}%")
                  ->orWhere('region', 'like', "%{$search}%")
                  ->orWhereHas('country', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        return DataTables::of($query)
            ->addColumn('country.name', function ($location) {
                return optional($location->country)->name ?? '-';
            })
            ->addColumn('actions', function ($location) {
                $actions = '';
                if (Gate::allows('locations_edit')) {
                    $actions .= '<a href="'.route('admin.location.edit', $location->id).'" class="edit-link">Edit</a> ';
                }
                if (Gate::allows('locations_delete')) {
                    $actions .= '<a href="#" class="delete-link js-ak-delete-link" data-id="'.$location->id.'">Delete</a>';
                }
                return $actions;
            })
            ->rawColumns(['actions']) // Allow HTML in actions column
            ->make(true);
    }

    // Normal blade view rendering
    $menu = $this->menu;
    //$locations_list_all =  Location::startSearch(Request()->query("location_search"))->orderByDesc("id")->get();
   $locations_list_all  = DB::select("
    SELECT locations.*, countries.countryname AS country_name
    FROM locations
    LEFT JOIN countries ON locations.country_id = countries.id
");

// foreach ($results as $row) {
//     echo $row->location_name . ' - ' . $row->region . ' - ' . ($row->country_name ?? '-') . '<br>';
// }
// dd($sql);
// dd($results);


    return view("admin.admin_location.index", compact('menu', 'locations_list_all'));
}


    public function create()
    {
         if (Gate::none('locations_create')) {
            abort(403);
        }
        $countries = Countries::all();
         $menu = $this->menu;
        $data = new Location();
        return view('admin.admin_location.form', compact('menu','countries', 'data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'location_name' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id'
        ]);

        Location::create($request->only('location_name', 'region', 'country_id'));

        return redirect()->route('admin.location.index')->with("toast_success", trans('admin/misc.success_confirmation_created'));
    }
    public function edit()
    {
       if (Gate::none('locations_edit')) {
            abort(403);
        }
        $menu = $this->menu;
        $locationId = request()->route('location_id');
$location = DB::select('SELECT * FROM locations WHERE id = ? LIMIT 1', [$locationId]);

// DB::select returns an array, get the first item or fail
if (empty($location)) {
    abort(404, 'Location not found');
}
$location = $location[0]; // stdClass object

// Get all countries
$countries = DB::select('SELECT * FROM countries');
        return view("admin.admin_location.form")->with(compact('menu', 'countries','location'));
    }
    public function update(Request $request)
    {
        if (Gate::none('admin_location_edit')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = Location::findOrFail(request()->route()->admin_location_id);
        $run->update($requestAll);
        return redirect(route("admin.location.index"))->with("toast_success", trans('admin/misc.success_confirmation_updated'));
    }



public function destroy(Request $request): JsonResponse
{
    $id = $request->input('delete_id');

    if (!$id) {
        return response()->json(['error' => 'No ID provided'], 400);
    }

    $deleted = DB::delete('DELETE FROM locations WHERE id = ?', [$id]);

    if (!$deleted) {
        return response()->json(['error' => 'Location not found or already deleted'], 404);
    }

    return response()->json(['success' => true]);
}




}
