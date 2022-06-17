<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\FileUpload;
use App\Models\Role;
use App\Models\User;
use App\Rules\MatchOldPassword;
use App\Traits\ResponseStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Throwable;

class UserController extends Controller
{
  use ResponseStatus;

  function __construct()
  {
//     $this->middleware('can:backend-users-list', ['only' => ['index', 'show']]);
//     $this->middleware('can:backend-users-create', ['only' => ['create', 'store']]);
//     $this->middleware('can:backend-users-edit', ['only' => ['edit', 'update']]);
//     $this->middleware('can:backend-users-delete', ['only' => ['destroy']]);
  }

  public function index(Request $request)
  {
    $config['page_title'] = "Pengguna Aplikasi";
    $page_breadcrumbs = [
      ['url' => '#', 'title' => "Daftar Pengguna Aplikasi"],
    ];

    if ($request->ajax()) {
      $data = User::with('roles');
      return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function ($row) {
          $actionBtn = '<div class="dropdown">
                        <button type="button" class="btn btn-primary" data-bs-toggle="dropdown" aria-expanded="false">
                          Aksi <i class="mdi mdi-chevron-down"></i>
                        </button>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="users/' . $row->id . '/edit">Ubah</a></li>
                          <li><a href="#" data-bs-toggle="modal" data-bs-target="#modalReset" data-bs-id="' . $row->id . '" class="dropdown-item">Reset Password</a></li>
                          <li> <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" data-bs-id="' . $row->id . '" class="delete dropdown-item">Hapus</a></li>
                        </ul>
                      </div> ';
          return $actionBtn;

        })
        ->editColumn('image', function (User $user) {
          $data = asset("/assets/img/svgs/no-content.svg");
          if(isset($user->image)){
           $data =  asset("/storage/images/thumbnail/$user->image");
          }
          return '<img class="rounded-circle" src="'.$data.'"alt="photo" style="width:75px; height: 75px;">';
        })
        ->rawColumns(['image', 'action'])
        ->make(true);
    }
    return view('backend.users.index', compact('config', 'page_breadcrumbs'));
  }

  public function create()
  {
    $config['page_title'] = "Tambah Pengguna";
    $page_breadcrumbs = [
      ['url' => route('backend.users.index'), 'title' => "Daftar Pengguna"],
      ['url' => '#', 'title' => "Tambah Pengguna"],
    ];
    return view('backend.users.create', compact('page_breadcrumbs', 'config'));
  }

  public function edit($id)
  {
    $config['page_title'] = "Edit Pengguna";

    $page_breadcrumbs = [
      ['url' => route('backend.users.index'), 'title' => "Daftar Pengguna"],
      ['url' => '#', 'title' => "Edit Pengguna"],
    ];
    $logInUser = Auth::user()->roles()->first()->slug ?? NULL;
    if ($id == Auth::id() || in_array($logInUser, ['super-admin', 'admin'])) {
      $user = User::findOrFail($id);

      $roles = Role::query()->select('slug');
      $userRole = $user->roles()->first();
      $roles->when($userRole->slug != 'super-admin', function ($q) {
        return $q->where('slug', '!=', 'super-admin')->pluck('slug', 'slug');
      });

      $data = [
        'user' => $user,
        'roles' => $roles->get()->toArray(),
        'userRole' => $userRole
      ];
    } else {
      return abort('401', 'Unauthorized');
    }

    return view('backend.users.edit', compact('page_breadcrumbs', 'config', 'data'));
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'role_id' => 'required|integer',
      'name' => 'required',
      'password' => 'required|between:6,255|confirmed',
      'email' => 'required|email|unique:users,email',
      'username' => 'required|unique:users,username',
      'active' => 'required|between:0,1',
      'image' => 'image|mimes:jpg,png,jpeg',
    ]);

    if ($validator->passes()) {
      $dimensions = [array('300', '300', 'thumbnail')];
      DB::beginTransaction();
      try {
        $img = isset($request->image) && !empty($request->image) ? FileUpload::uploadImage('image', $dimensions) : NULL;
        $data = User::create([
          'name' => ucwords($request['name']),
          'image' => $img,
          'email' => $request['email'],
          'username' => $request['username'],
          'password' => Hash::make($request['password']),
          'active' => $request['active'],
        ]);
        $data->save();
        $data->markEmailAsVerified();
        $role = Role::find($request['role_id']);
        $data->roles()->attach($role);

        DB::commit();
        $response = response()->json($this->responseStore(true, route('backend.users.index')));
      } catch (Throwable $throw) {
        dd($throw);
        DB::rollBack();
        $response = response()->json($this->responseStore(false));
      }
    } else {
      $response = response()->json(['error' => $validator->errors()->all()]);
    }
    return $response;
  }

  public function update(Request $request, $id)
  {
    $logInUser = Auth::user()->roles()->first()->slug ?? NULL;
    if ($id == Auth::id() || in_array($logInUser, ['super-admin', 'admin'])) {
      $validator = Validator::make($request->all(), [
        'role_id' => 'required|integer',
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . $id,
        'username' => 'required|unique:users,username,' . $id,
        'active' => 'required|between:0,1',
        'image' => 'image|mimes:jpg,png,jpeg',
      ]);

      $data = User::findOrFail($id);
      if ($validator->passes()) {
        $image = NULL;
        $dimensions = [array('300', '300', 'thumbnail')];
        try {
          DB::beginTransaction();
          if (isset($request['image']) && !empty($request['image'])) {
            $image = FileUpload::uploadImage('image', $dimensions, 'storage', $data['image']);
          }
          $data->update([
            'name' => ucwords($request['name']),
            'email' => $request['email'],
            'username' => $request['username'],
            'active' => $request['active'],
            'image' => $image,
          ]);

          if (isset($request['role_id'])) {
            $role = Role::findOrFail($request['role_id']);
            $data->roles()->detach();
            $data->roles()->attach($role);
          }
          DB::commit();
          $response = response()->json($this->responseUpdate(true, route('backend.users.index')));
        } catch (Throwable $e) {
          DB::rollback();
          $response = response()->json($this->responseUpdate(false));
        }
      } else {
        $response = response()->json(['error' => $validator->errors()->all()]);
      }
    } else {
      return abort('401');
    }
    return $response;
  }

  public function destroy($id)
  {
    $data = User::find($id);
    $response = response()->json($this->responseDelete(true));
    if ($data->delete()) {
      File::delete(["images/original/$data->image", "images/thumbnail/$data->image"]);
      $response = response()->json($this->responseDelete(true));
    }
    return $response;
  }

  public function resetpassword(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'id' => 'required|integer',
    ]);

    if ($validator->passes()) {
      $data = User::find($request->id);
      $data->password = Hash::make($data['email']);
      if ($data->save()) {
        $response = response()->json($this->responseUpdate(true));;
      }
    } else {
      $response = response()->json(['error' => $validator->errors()->all()]);
    }
    return $response;
  }

  public function changepassword(Request $request)
  {
    $data = Auth::user();

    $validator = Validator::make($request->all(), [
      'old_password' => ['required', new MatchOldPassword(Auth::id())],
      'password' => 'required|between:6,255|confirmed',
    ]);

    if ($validator->passes()) {
      $data->password = Hash::make($request['password']);
      if ($data->save()) {
        $response = response()->json($this->responseUpdate(true));
      }
    } else {
      $response = response()->json(['error' => $validator->errors()->all()]);
    }
    return $response;
  }
}
