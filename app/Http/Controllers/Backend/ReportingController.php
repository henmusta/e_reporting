<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reporting;

class ReportingController extends Controller
{
    public function select2(Request $request)
    {
      $page = $request->page;
      $status = $request->status;
      $resultCount = 10;
      $offset = ($page - 1) * $resultCount;
      $data = Reporting::where('nama_paket', 'LIKE', '%' . $request->q . '%')
        ->when($status, function ($query, $status) {
          return $query->where('status', $status);
         })
        ->orderBy('nama_paket')
        ->skip($offset)
        ->take($resultCount)
        ->selectRaw('id,CONCAT(kode,"-",nama_paket) as text, keterangan, perusahaan, nilai_kontrak')
        ->get();

      $count = Reporting::where('nama_paket', 'LIKE', '%' . $request->q . '%')
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


    public function update(Request $request, $id)
    {
       $validator = Validator::make($request->all(), [
        'tgl_buat' => 'required',
        'perusahaan' => 'perusahaan',
      ]);

      if ($validator->passes()) {
        DB::beginTransaction();
        try {
          $data = Reporting::findOrFail($id);
          $data->update([
            'keterangan' => $request['keterangan'],
            'tgl_buat' => $request['tgl_buat'],
            'perusahaan' => $request['perusahaan'],
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
}
