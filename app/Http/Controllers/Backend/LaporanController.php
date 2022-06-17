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

class LaporanController extends Controller
{
    use ResponseStatus, NoUrutTrait, CarbonFormat;

    public function index(Request $request)
    {
      $config['page_title'] = "Laporan";
      $page_breadcrumbs = [
        ['url' => '#', 'title' => "Laporan"],
      ];
      if ($request->ajax()) {
        $status = $request['status'];
        $data = Reporting::query()
          ->when($status, function ($query, $status) {
            return $query->where('status', $status);
          });
        return DataTables::of($data)

          ->addColumn('action', function ($row) {
            return
              '<a type="buttton" class="btn btn-primary my-2 btn-icon-text" href="laporan/' . $row->id . '">Detail</a>';
          })
          ->make(true);
      }

      return view('backend.laporan.index', compact('config', 'page_breadcrumbs'));
    }

    public function show($id)
    {
      $config['page_title'] = "Laporan";
      $page_breadcrumbs = [
        ['url' => route('backend.laporan.index'), 'title' => "Laporan"],
        ['url' => '#', 'title' => "Detail Laporan"],
      ];
      $reporting = Reporting::findOrFail($id);
      $reporting_log = Reporting_log::where('reporting_id',  $reporting['id'])->get();
      $data = [
        'reporting' =>$reporting,
        'reporting_log' => $reporting_log,
      ];
      return view('backend.laporan.show', compact('page_breadcrumbs', 'config', 'data'));
    }

}
