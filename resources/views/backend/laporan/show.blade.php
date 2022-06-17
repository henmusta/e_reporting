@extends('layouts.master')

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex flex-row mb-4 align-self-center">
            <div class="me-4">
              <img width="200px" height="75px" src="{{URL::to('storage/images/logo/'.Setting::get_setting()->logo)}}">
            </div>
            <div>
              <h5 class="m-0"></h5>
              <h6 class="m-0"></h6>

            </div>
          </div>
          <div class="row">
            <div class="col-4">

            </div>
            <div class="col-4">
              <div>
                <h5 class="font-size-15 mb-3"></h5>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-3">
              <table class="table-borderless border-0">
                <tr>
                  <td><strong>Nama Paket</strong></td>
                  <td> :</td>
                  <td><strong>{{ $data['reporting']['nama_paket'] ?? '' }}</strong></td>
                </tr>
              </table>
            </div>

            <div class="col-3">
              <table class="table-borderless">
                <tr>
                  <td><strong>Perusahaan</strong></td>
                  <td> :</td>
                  <td><strong>{{ $data['reporting']['perusahaan'] ?? '' }}</strong></td>
                </tr>
              </table>
            </div>
            <div class="col-3">
                <table class="table-borderless">
                  <tr>
                    <td><strong>Nilai Kontrak</strong></td>
                    <td> :</td>
                    <td><strong>{{ $data['reporting']['nilai_kontrak'] != 0 ?  'Rp. ' . number_format($data['reporting']['nilai_kontrak'], 0, '.', ',') : 'Rp. 0' }}</strong></td>
                  </tr>
                </table>
              </div>
              <div class="col-3">
                <table class="table-borderless">
                  <tr>
                    <td><strong>Status Terakhir</strong></td>
                    <td> :</td>
                    <td><strong>{{ $data['reporting']['status'] ?? '' }}</strong></td>
                  </tr>
                </table>
              </div>

          </div>
          <div class="py-2 mt-3">
            <h5 class="font-size-15">Detail Riwayat Paket</h5>
          </div>
          <div class="p-4 border-0">
            <div class="table-responsive">
              <table class="table table-sm mb-0">
                <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Kode</th>
                  <th>Keterangan</th>
                  <th class="text-center">status</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data['reporting_log'] as $i => $val )
                  <tr>
                    <td>{{ $val->tgl_buat ?? '-' }}</td>
                    <td>{{ $val->kode ?? '-' }}</td>
                    <td>{{ $val->keterangan ?? '-' }}</td>
                    <td>{{ $val->status ?? '-' }}</td>
                    {{-- <td>{{ $v->note ?? '-' }}</td>
                    <td class="text-end">{{ $v->debit != 0 ?  'Rp. ' . number_format($v->debit, 0, '.', ',') : 'Rp. 0' }}</td>
                    <td class="text-end">{{ $v->credit != 0 ?  'Rp. ' .number_format($v->credit, 0, '.', ',') : 'Rp. 0' }}</td> --}}
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <div class="d-print-none mt-3">
            <div class="float-end">
              <a href="javascript:window.print()" class="btn btn-success">
                <i class="fa fa-print"></i> Cetak</a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
@endsection

