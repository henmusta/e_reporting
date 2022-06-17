@extends('layouts.master')

@section('content_corner')
  <!-- <a class="btn btn-primary my-2 btn-icon-text" href="#" class="btn btn-primary" data-bs-toggle="modal"
     data-bs-target="#modalCreate">
    <i class="fe fe-plus"></i> Tambah
  </a> -->
@endsection
@section('content')
  <div class="row row-sm">
    <div class="col-lg-12">
      <div class="card custom-card overflow-hidden">
        <div class="card-body">
          <div class="row">

          </div>
          <div class="table-responsive">
            <table id="Datatable" class="table table-bordered  margin-top-10 w-p100">
              <thead>
              <tr>
                <th>Nama Web</th>
                <th>Text Logo</th>
                <th>Logo</th>
                <th>Favicon</th>
                <th>Background Login</th>
                <th>Aksi</th>
              </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('css')
<link rel="stylesheet" type="text/css"
href="https://cdn.datatables.net/v/bs5/dt-1.11.3/b-2.0.1/b-colvis-2.0.1/fc-4.0.1/fh-3.2.0/r-2.2.9/rg-1.1.4/rr-1.2.8/datatables.min.css"/>
@endsection
@section('script')

<script type="text/javascript"
  src="https://cdn.datatables.net/v/bs5/dt-1.11.3/b-2.0.1/b-colvis-2.0.1/fc-4.0.1/fh-3.2.0/r-2.2.9/rg-1.1.4/rr-1.2.8/datatables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.js"></script>
  <script>
    $(document).ready(function () {
      // let modalCreate = document.getElementById('modalCreate');
      // const bsCreate = new bootstrap.Modal(modalCreate);
      // let modalEdit = document.getElementById('modalEdit');
      // const bsEdit = new bootstrap.Modal(modalEdit);
      // let modalDelete = document.getElementById('modalDelete');
      // const bsDelete = new bootstrap.Modal(modalDelete);
      let dataTable = $('#Datatable').DataTable({
        responsive: true,
        scrollX: false,
        processing: true,
        serverSide: true,
        order: [[0, 'asc']],
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        pageLength: 10,
        ajax: "{{ route('backend.settings.index') }}",
        columns: [
          {data: 'nama', name: 'nama'},
          {data: 'logo', name: 'logo'},
          {data: 'small_logo', name: 'small_logo'},
          {data: 'favicon', name: 'favicon'},
          {data: 'background', name: 'background'},
          {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        columnDefs: [

        ],
      });
    });
  </script>
@endsection
