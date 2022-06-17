<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reporting;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
      $config['page_title'] = "Dashboard";
      $page_breadcrumbs = [
        ['url' => '#', 'title' => "Dashboard"],
      ];

      $totalterumumkan = Reporting::where('status', 'Terumumkan')->count();
      $totalproseskontrak = Reporting::where('status', 'Proses Kontrak')->count();
      $totalpelaksanaan = Reporting::where('status', 'Pelaksanaan')->count();
      $totalselesai = Reporting::where('status', 'Selesai')->count();

      $data = [
        'terumumkan' => $totalterumumkan,
        'proseskontrak' => $totalproseskontrak,
        'pelaksanaan' => $totalpelaksanaan,
        'selesai' => $totalselesai,
      ];


      return view('backend.dashboard.index', compact('config','data', 'page_breadcrumbs'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
