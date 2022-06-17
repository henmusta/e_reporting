<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Helpers\FileUpload;
use App\Models\Settings;
use App\Traits\ResponseStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SettingsController extends Controller
{
    use ResponseStatus;
    public function index(Request $request)
    {
      $config['page_title'] = "Pengaturan Web";
      $page_breadcrumbs = [
        ['url' => '#', 'title' => "Pengaturan Web"],
      ];

      if ($request->ajax()) {
        $data = Settings::query();
        return DataTables::of($data)
          ->addIndexColumn()
          ->addColumn('action', function ($row) {
            $actionBtn = '<div class="dropdown">
                                <button type="button" class="btn btn-primary" data-bs-toggle="dropdown" aria-expanded="false">
                                  Aksi <i class="mdi mdi-chevron-down"></i>
                                </button>
                                <ul class="dropdown-menu">
                                  <li><a class="dropdown-item" href="settings/' . $row->id . '/edit">Ubah</a></li>
                                </ul>
                              </div> ';
            return $actionBtn;
          })
          ->editColumn('logo', function (Settings $Settings) {
            $data = asset("/assets/img/svgs/no-content.svg");
            if (isset($Settings->logo)) {
              $data =  asset("/storage/images/logo/$Settings->logo");
            }
            return '<img class="rounded-circle" src="' . $data . '"alt="photo" style="width:75px; height: 75px;">';
          })
          ->editColumn('small_logo', function (Settings $Settings) {
            $data = asset("/assets/img/svgs/no-content.svg");
            if (isset($Settings->small_logo)) {
              $data =  asset("/storage/images/logo/$Settings->small_logo");
            }
            return '<img class="" src="' . $data . '"alt="photo" style="width:150px; height: 50px;">';
          })
          ->editColumn('favicon', function (Settings $Settings) {
            $data = asset("/assets/img/svgs/no-content.svg");
            if (isset($Settings->favicon)) {
              $data =  asset("/storage/images/backend/$Settings->favicon");
            }
            return '<img class="rounded-circle" src="' . $data . '"alt="photo" style="width:75px; height: 75px;">';
          })
          ->editColumn('background', function (Settings $Settings) {
            $data = asset("/assets/img/svgs/no-content.svg");
            if (isset($Settings->background)) {
              $data =  asset("/storage/images/backend/$Settings->background");
            }
            return '<img class="rounded-circle" src="' . $data . '"alt="photo" style="width:75px; height: 75px;">';
          })
          ->rawColumns(['logo', 'favicon', 'background', 'small_logo', 'action'])
          ->make(true);
      }

      return view('backend.settings.index', compact('config', 'page_breadcrumbs'));
    }

    public function edit($id)
    {
      $config['page_title'] = "Edit Pengaturan Web";

      $page_breadcrumbs = [
        ['url' => route('backend.settings.index'), 'title' => "Pengaturan Web"],
        ['url' => '#', 'title' => "Edit Pengaturan Web"],
      ];
      $data = Settings::findOrFail($id);

      return view('backend.settings.edit', compact('page_breadcrumbs', 'config', 'data'));
    }

    public function update(Request $request, $id)
    {
      $validator = Validator::make($request->all(), [
        'logo' => 'image|mimes:jpg,png,jpeg',
        'nama' => 'required',
      ]);

      $data = Settings::findOrFail($id);
      if ($validator->passes()) {
        $image = NULL;
        $dimensions = [array('300', '300', 'backend')];
        $dimensions_logo = [array('600', '600', 'logo')];
        $dimensions_small_logo = [array('633', '104', 'logo')];
        $dimensions_background = [array('1920', '1080', 'backend')];
        try {
          DB::beginTransaction();
          if (isset($request['small_logo']) && !empty($request['small_logo'])) {
            $small_logo = FileUpload::uploadImage('small_logo', $dimensions_small_logo, 'storage', $data['small_logo']);
          } else {
            $small_logo =  $data['small_logo'];
          }
          if (isset($request['logo']) && !empty($request['logo'])) {
            $logo = FileUpload::uploadImage('logo', $dimensions_logo, 'storage', $data['logo']);
          } else {
            $logo =  $data['logo'];
          }
          if (isset($request['favicon']) && !empty($request['favicon'])) {
            $favicon = FileUpload::uploadImage('favicon', $dimensions, 'storage', $data['favicon']);
          } else {
            $favicon = $data['favicon'];
          }
          if (isset($request['background']) && !empty($request['background'])) {
            $background = FileUpload::uploadImage('background', $dimensions_background, 'storage', $data['background']);
          } else {
            $background = $data['background'];
          }
          $data->update([
            'favicon' => $favicon,
            'logo' => $logo,
            'small_logo' => $small_logo,
            'background' => $background,
            'nama' => $request['nama']
          ]);

          DB::commit();
          $response = response()->json($this->responseUpdate(true, route('backend.settings.index')));
        } catch (\Throwable $e) {
          dd($e);
          DB::rollback();
          $response = response()->json($this->responseUpdate(false));
        }
      } else {
        $response = response()->json(['error' => $validator->errors()->all()]);
      }

      return $response;
    }

}
