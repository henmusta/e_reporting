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


class ProsesKontrakController extends Controller
{

    use ResponseStatus, NoUrutTrait, CarbonFormat;

    public function index(Request $request)
    {
      $config['page_title'] = "Proses Kontrak";
      $page_breadcrumbs = [
        ['url' => '#', 'title' => "Prosses Kontrak"],
      ];
      if ($request->ajax()) {
        $data = Reporting::where('status',  'Proses Kontrak');
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
                data-bs-tgl_buat="' . $row->tgl_buat . '"
                data-bs-keterangan="' . $row->keterangan . '"
                data-bs-perusahaan="' . $row->perusahaan . '" class="edit dropdown-item">Edit</a></li>
                <li> <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" data-bs-id="' . $row->id . '" class="delete dropdown-item">Delete</a></li>
              </ul>
            </div>';
          })
          ->make(true);
      }

      return view('backend.proseskontrak.index', compact('config', 'page_breadcrumbs'));
    }

    public function update(Request $request, $id)
    {
       $validator = Validator::make($request->all(), [
        'tgl_buat' => 'required',
        'paket_id' => 'required',
      ]);

      if ($validator->passes()) {
        DB::beginTransaction();
        try {
          $data = Reporting::findOrFail($id);
          $kode = ($request['report_id'] != null)   ? $data['kode'] : $this->nourutproses($request['tgl_buat']);
          $data->update([
            'keterangan' => $request['keterangan'],
            'tgl_buat' => $request['tgl_buat'],
            'perusahaan' => $request['perusahaan'],
            'kode' =>   $kode,
          ]);
          if($data->save()){
            $data->update([
                'status' => 'Proses Kontrak'
            ]);

            $data_log = Reporting_log::where([
                ['reporting_id' , $data['id']],
                ['status' ,'Proses Kontrak']
            ]);

            // dd($data_log->count());
            if($data_log->count() <= 0){
                 $log = Reporting_log::create([
                    'reporting_id' =>$data['id'],
                    'tgl_buat' => $data['tgl_buat'],
                    'kode' =>   $data['kode'],
                    'status' =>  $data['status'],
                    'keterangan' =>  $data['keterangan'],
                    'perusahaan' =>  $data['perusahaan']
                  ]);
            }else{
                $log = $data_log->first();
                $log->update([
                    'reporting_id' =>$data['id'],
                    'tgl_buat' => $data['tgl_buat'],
                    'kode' =>   $data['kode'],
                    'status' =>  $data['status'],
                    'keterangan' =>  $data['keterangan'],
                    'perusahaan' =>  $data['perusahaan']
                ]);
            }


          }

          DB::commit();
          $response = response()->json($this->responseUpdate(true));

        } catch (Throwable $throw) {
            dd($throw);
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

      $data_log_prs = Reporting_log::where([
        ['reporting_id' , $id],
        ['status' ,'Proses Kontrak']
      ])->first();
      if (isset($data_log)) {
        DB::beginTransaction();
        try {

        $data->update([
            'keterangan' =>$data_log['keterangan'],
            'tgl_buat' =>$data_log['tgl_buat'],
            'perusahaan' =>$data_log['perusahaan'],
            'kode' =>  $data_log['kode'],
            'status' =>   'Terumumkan'
        ]);

        $data_log_prs->delete();

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
