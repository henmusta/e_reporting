<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\Reporting;
use App\Models\Reporting_log;
use App\Traits\NoUrutTrait;
use App\Models\Paket;
use App\Traits\CarbonFormat;
use Illuminate\Http\Request;
use App\Traits\ResponseStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Throwable;
class TerumumkanController extends Controller
{
    use ResponseStatus, NoUrutTrait, CarbonFormat;

    public function index(Request $request)
    {
      $config['page_title'] = "Terumumkan";
      $page_breadcrumbs = [
        ['url' => '#', 'title' => "Terumumkan"],
      ];
      if ($request->ajax()) {
        $data = Reporting::where('status',  'Terumumkan');
        return DataTables::of($data)
          ->addColumn('action', function ($row) {
            return
              '<div class="dropdown">
              <button type="button" class="btn btn-primary" data-bs-toggle="dropdown" aria-expanded="false">
                Aksi <i class="mdi mdi-chevron-down"></i>
              </button>
              <ul class="dropdown-menu">
                <li> <a href="#" data-bs-toggle="modal" data-bs-target="#modalEdit"
                data-bs-id="' . $row->id . '"
                data-bs-paket="' . $row->nama_paket . '"
                data-bs-keterangan="' . $row->keterangan . '" class="edit dropdown-item">Edit</a></li>
                <li> <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" data-bs-id="' . $row->id . '" class="delete dropdown-item">Delete</a></li>
              </ul>
            </div>';
          })
          ->make(true);
      }

      return view('backend.terumumkan.index', compact('config', 'page_breadcrumbs'));
    }

    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'paket_id' => 'required',
        'tgl_buat' => 'required',
      ]);

      if ($validator->passes()) {
        DB::beginTransaction();
        try {
          $paket = Paket::findOrFail($request['paket_id']);
          $data = Reporting::create([
            'paket_id' => $request['paket_id'],
            'kode' => $this->nourutumum($request['tgl_buat']),
            'tgl_buat' => $request['tgl_buat'],
            'nama_paket' => $paket['paket'],
            'keterangan' => $request['keterangan'],
            'status' => 'Terumumkan'
          ]);



          if($data->save()){

            $paket->update([
                'status' => 'Digunakan'
            ]);
            $data->update([
                'status' => 'Terumumkan'
            ]);

            $data_log = Reporting_log::where([
                ['reporting_id' , $data['id']],
                ['status' ,'Terumumkan']
            ]);

            // dd($data_log->count());
            if($data_log->count() <= 0){
                 $log = Reporting_log::create([
                    'reporting_id' => $data['id'],
                    'tgl_buat' => $data['tgl_buat'],
                    'keterangan' => $data['keterangan'],
                    'kode' =>    $data['kode'],
                    'status' =>  'Terumumkan'
                  ]);
            }

          }

          DB::commit();
          $response = response()->json($this->responseStore(true));
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
       $validator = Validator::make($request->all(), [
        // 'tgl_buat' => 'required',
      ]);

      if ($validator->passes()) {
        DB::beginTransaction();
        try {
          $data = Reporting::findOrFail($id);
          $data->update([
            'keterangan' => $request['keterangan'],
            // 'tgl_buat' => $request['tgl_buat'],
          ]);

          $data_log = Reporting_log::where([
            ['reporting_id' , $id],
            ['status' ,'Terumumkan']
          ])->first();

          $data_log->update([
            'keterangan' => $request['keterangan'],
            'tgl_buat' => $request['tgl_buat'],
          ]);

          DB::commit();
          $response = response()->json($this->responseUpdate(true));

        } catch (Throwable $throw) {
          DB::rollBack();
          $response = response()->json($this->responseUpdate(false));
        }
      } else {
        $response = response()->json(['error' => $validator->errors()->all()]);
      }
      return $response;
    }



    public function destroy($id)
    {
      $data = Reporting::findOrFail($id);
      $data_log = Reporting_log::where([
        ['reporting_id' , $id],
        ['status' ,'Terumumkan']
      ])->first();
      $paket = Paket::findOrFail($data['paket_id']);
      if ($data->delete()&& $data_log->delete()) {
        DB::beginTransaction();
        try {
        $paket->update([
            'status' => 'Aktif'
        ]);

        DB::commit();
        $response = response()->json($this->responseStore(true));
          } catch (Throwable $throw) {
            dd($throw);
            DB::rollBack();
            $response = response()->json($this->responseStore(false));
        }
      }
      return $response;
    }
}
