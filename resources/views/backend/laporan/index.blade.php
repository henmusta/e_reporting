@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-12">
      <div class="box">
        <div class="box-header with-border">
            <div class="row">
                <div class="col-4">
                    <select class="form-select" id="select2Status" name="select2Status">
                      <option value="">Semua Status</option>
                      <option value="Terumumkan">Terumumkan</option>
                      <option value="Proses Kontrak">Proses Kontrak</option>
                      <option value="Pelaksanaan">Pelaksanaan</option>
                      <option value="Selesai">Selesai</option>
                    </select>
                </div>
                <div class="col-8">
                    <div id="print" style="float:right">
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
              <table id="Datatable" class="table table-bordered  margin-top-10 w-p100">
                <thead>
                    <tr>
                        <th>Nama Paket</th>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Perusahaan</th>
                        <th>Keterangan</th>
                        <th>Nilai Kontrak</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            </div>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>


@endsection

@section('css')
<style>
.dataTables_wrapper .dt-buttons {
  float:none;
  text-align:center;
}
</style>
<link rel="stylesheet" type="text/css"  href="https://cdn.datatables.net/buttons/1.4.0/css/buttons.dataTables.min.css" />
  <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs5/dt-1.11.3/b-2.0.1/b-colvis-2.0.1/fc-4.0.1/fh-3.2.0/r-2.2.9/rg-1.1.4/rr-1.2.8/datatables.min.css"/>
@endsection
@section('script')
<script src="{{ asset('assets/vendor_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendor_components/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/vendor_components/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendor_components/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/vendor_components/pdfmake/build/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/vendor_components/pdfmake/build/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/vendor_components/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/vendor_components/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/vendor_components/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
  <script>
      let datatable;


    $(document).ready(function () {

      let select2Status = $('#select2Status');


      dataTable = $('#Datatable').DataTable({
        dom: 'lfBrtip',
        buttons: [
            {
                extend: 'pdfHtml5',
                title: 'Laporan',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                },
                // customize : function(doc) {
                //     doc.styles['td:nth-child(2)'] = {
                //     width: '200px',
                //     'max-width': '200px'
                //     }
                // }
            },
            {
                extend: 'excel',
                title: 'Laporan',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }
            },

        ],
        // responsive: true,
        scrollX: false,
        processing: true,
        serverSide: true,
        order: [[0, 'asc']],
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        pageLength: 10,
        // ajax: "{{ route('backend.laporan.index') }}",
        ajax: {
          url: "{{ route('backend.laporan.index') }}",
          data: function (d) {
            d.status = $('#select2Status').find(':selected').val();
          }
        },
        columns: [
          {data: 'nama_paket', name: 'nama_paket'},
          {data: 'kode', name: 'kode'},
          {data: 'tgl_buat', name: 'tgl_buat'},
          {data: 'perusahaan', name: 'perusahaan'  ,defaultContent: '-'},
          {data: 'keterangan', name: 'keterangan'},
          {data: 'nilai_kontrak', class:'text-end' , defaultContent: '-', name: 'nilai_kontrak', render: $.fn.dataTable.render.number(',', '.', 0, '')},
          { data: 'status',
            name: 'status',
            className: 'text-center',
            orderable: false,
              render: function(columnData, type, rowData, meta) {
                var st = (columnData === 'Selesai') ? 'success' :  (columnData === 'Pelaksanaan') ? 'warning' :  (columnData === 'Proses Kontrak') ? 'dark' : 'secondary';
                // if(columnData = 'Selesai'){
                //     let st = 'success';
                // }
                return ' <span class="badge badge-'+st+'">'+columnData+'</span>';
              }
          },
          {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        columnDefs: [

        ],
      });
      dataTable.buttons().container().appendTo($('#print'));

       $("#tgl_buat").flatpickr({
            dateFormat: "Y-m-d"
        });

        select2Status.select2({
        dropdownParent: select2Status.parent(),
        placeholder: "Pilih Status",
        allowClear: true,
        width: '100%'
      }).on('change', function () {
        dataTable.draw();
      });


    });
  </script>
@endsection
