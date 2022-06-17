<?php

namespace App\Traits;
use App\Models\Reporting;
use Carbon\Carbon;

trait NoUrutTrait
{

  public function noUrutumum($date)
  {
    $tgl = date('Y-m-d', strtotime(str_replace('.', '/', $date)));
    $noUrut = Reporting::selectRaw("IFNULL(MAX(SUBSTRING(`kode`, 12, 4)), 0) + 1 AS max")
        ->whereDate('tgl_buat', $tgl)
        ->where('status', 'Terumumkan')
        ->first()->max ?? 0;
        $noUrutNext = "UMM." . Carbon::createFromFormat('Y-m-d', $tgl)->format('ymd') . "." . str_pad($noUrut, 4, "0", STR_PAD_LEFT);
    return $noUrutNext;
  }

  public function noUrutproses($date)
  {
    $tgl = date('Y-m-d', strtotime(str_replace('.', '/', $date)));
    $noUrut = Reporting::selectRaw("IFNULL(MAX(SUBSTRING(`kode`, 12, 4)), 0) + 1 AS max")
        ->whereDate('tgl_buat', $tgl)
        ->where('status', 'Proses Kontrak')
        ->first()->max ?? 0;
        $noUrutNext = "PRS." . Carbon::createFromFormat('Y-m-d', $tgl)->format('ymd') . "." . str_pad($noUrut, 4, "0", STR_PAD_LEFT);
    return $noUrutNext;

  }


  public function noUrutpelaksanaan($date)
  {
    $tgl = date('Y-m-d', strtotime(str_replace('.', '/', $date)));
    $noUrut = Reporting::selectRaw("IFNULL(MAX(SUBSTRING(`kode`, 12, 4)), 0) + 1 AS max")
        ->whereDate('tgl_buat', $tgl)
        ->where('status', 'Terumumkan')
        ->first()->max ?? 0;
        $noUrutNext = "PSN." . Carbon::createFromFormat('Y-m-d', $tgl)->format('ymd') . "." . str_pad($noUrut, 4, "0", STR_PAD_LEFT);
    return $noUrutNext;

  }

  public function noUrutselesai($date)
  {
    $tgl = date('Y-m-d', strtotime(str_replace('.', '/', $date)));
    $noUrut = Reporting::selectRaw("IFNULL(MAX(SUBSTRING(`kode`, 12, 4)), 0) + 1 AS max")
        ->whereDate('tgl_buat', $tgl)
        ->where('status', 'Terumumkan')
        ->first()->max ?? 0;
        $noUrutNext = "SLI." . Carbon::createFromFormat('Y-m-d', $tgl)->format('ymd') . "." . str_pad($noUrut, 4, "0", STR_PAD_LEFT);
    return $noUrutNext;

  }
}
