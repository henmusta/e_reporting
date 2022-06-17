<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use App\Traits\ResponseStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Throwable;

class PaketController extends Controller
{
    use ResponseStatus;

    public function index(Request $request)
    {
      $config['page_title'] = "Paket";
      $page_breadcrumbs = [
        ['url' => '#', 'title' => "Paket"],
      ];
      if ($request->ajax()) {
        $data = Paket::query();
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
                data-bs-paket="' . $row->paket . '"
                data-bs-keterangan="' . $row->keterangan . '"
                data-bs-status="' . $row->status . '" class="edit dropdown-item">Edit</a></li>
                <li> <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" data-bs-id="' . $row->id . '" class="delete dropdown-item">Delete</a></li>
              </ul>
            </div>';

          })
          ->make(true);
      }

      return view('backend.Paket.index', compact('config', 'page_breadcrumbs'));
    }

    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'paket' => 'required|string',
        'SelectStatus' => 'required|string',
        'keterangan' => 'required|string',
      ]);

      if ($validator->passes()) {
        DB::beginTransaction();
        try {
          $Paket = Paket::create([
            'paket' => ucwords($request['paket']),
            'status' => $request['SelectStatus'],
            'keterangan' => $request['keterangan']
          ]);
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
            'paket' => 'required|string',
            'SelectStatus' => 'required|string',
            'keterangan' => 'required|string',
          ]);

      if ($validator->passes()) {
        DB::beginTransaction();
        try {
          $Paket = Paket::findorfail($id);
          $Paket->update([
            'paket' => ucwords($request['paket']),
            'status' => $request['SelectStatus'],
            'keterangan' => $request['keterangan']
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

    public function select2(Request $request)
    {
      $page = $request->page;
      $status = $request->status;
      $resultCount = 10;
      $offset = ($page - 1) * $resultCount;
      $data = Paket::where('paket', 'LIKE', '%' . $request->q . '%')
         ->when($status, function ($query, $status) {
            return $query->where('status', $status);
         })
        ->orderBy('paket')

        ->skip($offset)
        ->take($resultCount)
        ->selectRaw('id, paket as text')
        ->get();


      $count = Paket::where('paket', 'LIKE', '%' . $request->q . '%')
        ->when($status, function ($query, $status) {
            return $query->where('status', $status);
        })
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

    public function destroy($id)
    {
      $data = Paket::findOrFail($id);
      if ($data->delete()) {
        $response = response()->json($this->responseDelete(true));

      }
      return $response;
    }
}
