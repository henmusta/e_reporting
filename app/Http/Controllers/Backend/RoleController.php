<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
  public function __construct()
  {
    $this->middleware('can:erp-roles-list', ['only' => ['index', 'show']]);
    $this->middleware('can:erp-roles-create', ['only' => ['index', 'create', 'store']]);
    $this->middleware('can:erp-roles-edit', ['only' => ['index', 'edit', 'update']]);
    $this->middleware('can:erp-roles-delete', ['only' => ['index', 'destroy']]);
  }

  public function index(Request $request)
  {
    $config['page_title'] = "Roles";
    $page_breadcrumbs = [
      ['url' => '#', 'title' => "Roles"],
    ];

    if ($request->ajax()) {
      $data = Role::whereNotIn('slug', ['super-admin']);
      return DataTables::of($data)
        ->addColumn('action', function ($row) {
          $actionBtn = '<div class="dropdown">
                          <button type="button" class="btn btn-primary" data-bs-toggle="dropdown" aria-expanded="false">
                            Aksi <i class="mdi mdi-chevron-down"></i>
                          </button>
                          <ul class="dropdown-menu">
                            <li> <a href="#" data-bs-toggle="modal" data-bs-target="#modalEdit" data-bs-id="' . $row->id . '" data-bs-name="' . $row->name . '" class="edit dropdown-item">Ubah</a></li>
                            <li> <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" data-bs-id="' . $row->id . '" class="delete dropdown-item">Hapus</a></li>
                          </ul>
                        </div> ';
          return $actionBtn;

        })
        ->make(true);
    }

    return view('erp.roles.index', compact('config', 'page_breadcrumbs'));
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required|unique:roles,name',
    ]);

    if ($validator->passes()) {
      Role::create([
        'name' => ucwords($request['name']),
      ]);

      $response = response()->json([
        'status' => 'success',
        'message' => 'Data berhasil disimpan'
      ]);
    } else {
      $response = response()->json(['error' => $validator->errors()->all()]);
    }
    return $response;
  }

  public function update(Request $request, $id)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required|unique:roles,name,' . $id,
    ]);

    if ($validator->passes()) {
      $data = Role::find($id);
      $data->update([
        'name' => ucwords($request['name']),
      ]);
      // if($data->slug != 'super-admin'){
      //   $data->update([
      //     'name' => ucwords($request['name']),
      //   ]);
      // }
      $response = response()->json([
        'status' => 'success',
        'message' => 'Data berhasil diubah',
      ]);
    } else {
      $response = response()->json(['error' => $validator->errors()->all()]);
    }
    return $response;
  }

  public function destroy(Role $role)
  {
    $response = response()->json([
      'status' => 'error',
      'message' => 'Data gagal dihapus'
    ]);
    if ($role->slug != 'super-admin') {
      $role->delete();
      $response = response()->json([
        'status' => 'success',
        'message' => 'Data berhasil dihapus'
      ]);
    }
    return $response;
  }

  public function select2(Request $request)
  {
    $page = $request->page;
    $resultCount = 10;
    $offset = ($page - 1) * $resultCount;
    $data = Role::where('name', 'LIKE', '%' . $request->q . '%')
      ->orderBy('name')
      ->skip($offset)
      ->take($resultCount)
      ->selectRaw('id, name as text')
      ->get();

    $count = Role::where('name', 'LIKE', '%' . $request->q . '%')
      ->get()
      ->count();

    $endCount = $offset + $resultCount;
    $morePages = $count > $endCount;

    $results = array(
      "results" => $data,
      "pagination" => array(
        "more" => $morePages
      )
    );

    return response()->json($results);
  }

}
