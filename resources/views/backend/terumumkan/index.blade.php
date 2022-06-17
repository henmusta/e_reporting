@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-12">
      <div class="box">
        <div class="box-header with-border">
            <div class="d-flex mb-3">
                <div class="ms-auto">
                    <a class="btn btn-primary my-2 btn-icon-text" href="#" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modalCreate">
                   <i class="fe fe-plus"></i> Tambah
                 </a>
                </div>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
              <table id="Datatable" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                <thead>
                    <tr>
                        <th>Nama Paket</th>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
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
    {{--Modal--}}
    <div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalResetLabel">Tambah</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formStore" method="POST" action="{{ route('backend.terumumkan.store') }}">
              @csrf
              <div class="modal-body">
                <div id="errorCreate" class="mb-3" style="display:none;">
                  <div class="alert alert-danger" role="alert">
                    <div class="alert-icon"><i class="flaticon-danger text-danger"></i></div>
                    <div class="alert-text">
                    </div>
                  </div>
                </div>
                <div class="mb-3">
                    <label>Paket<span class="text-danger">*</span></label>
                    <select class="form-control" id="select2Paket" name="paket_id" >
                    </select>
                </div>
                <div class="mb-3">
                    <label>Tanggal<span class="text-danger">*</span></label>
                    <input type="text" name="tgl_buat" id="tgl_buat" class="form-control" />
                </div>
                <div class="mb-3">
                    <label>Keterangan<span class="text-danger">*</span></label>
                    <textarea name="keterangan" id="keterangan" class="yourmessage form-control" ></textarea>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalmodalEdit" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit {{ $config['page_title'] }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formUpdate" action="#">
              @method('PUT')
              <meta name="csrf-token" content="{{ csrf_token() }}">
              <div class="modal-body">
                <div id="errorEdit" class="mb-3" style="display:none;">
                  <div class="alert alert-danger" role="alert">
                    <div class="alert-icon"><i class="flaticon-danger text-danger"></i></div>
                    <div class="alert-text">
                    </div>
                  </div>
                </div>
                  <div class="mb-3">
                    <label>Nama Paket<span class="text-danger">*</span></label>
                    <input type="text" name="paket" class="form-control" disabled/>
                  </div>
                  <div class="mb-3">
                    <label>Keterangan<span class="text-danger">*</span></label>
                    <textarea name="keterangan" id="keteranganedit" class="yourmessage form-control" ></textarea>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalDeleteLabel">Hapus</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            @method('DELETE')
            <div class="modal-body">
              <a href="" class="urlDelete" type="hidden"></a>
              Apa anda yakin ingin menghapus data ini?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
              <button id="formDelete" type="button" class="btn btn-primary">Submit</button>
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
      let modalCreate = document.getElementById('modalCreate');
      const bsCreate = new bootstrap.Modal(modalCreate);
      let modalEdit = document.getElementById('modalEdit');
      let select2Paket = $('#select2Paket');
      const bsEdit = new bootstrap.Modal(modalEdit);
      let modalDelete = document.getElementById('modalDelete');
      const bsDelete = new bootstrap.Modal(modalDelete);
      let dataTable = $('#Datatable').DataTable({
        responsive: true,
        scrollX: false,
        processing: true,
        serverSide: true,
        order: [[0, 'asc']],
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        pageLength: 10,
        ajax: "{{ route('backend.terumumkan.index') }}",
        columns: [
          {data: 'nama_paket', name: 'nama_paket'},
          {data: 'kode', name: 'kode'},
          {data: 'tgl_buat', name: 'tgl_buat'},
          {data: 'keterangan', name: 'keterangan'},
          { data: 'status',
            name: 'status',
            className: 'text-center',
            orderable: false,
              render: function(columnData, type, rowData, meta) {
                return ' <span class="badge badge-secondary">'+columnData+'</span>';
              }
          },
          {data: 'action', name: 'action', orderable: false, searchable: false},

        ],
        columnDefs: [
        ],
      });

       $("#tgl_buat").flatpickr({
            dateFormat: "Y-m-d"
        });


      modalCreate.addEventListener('show.bs.modal', function (event) {
      });
      modalCreate.addEventListener('hidden.bs.modal', function (event) {
        $(this).find('#select2Paket').val('').trigger('change');
        $(this).find('#tgl_buat').val('');
        $(this).find('#keterangan').text('');
      });
      modalEdit.addEventListener('show.bs.modal', function (event) {
        let paket = event.relatedTarget.getAttribute('data-bs-paket');
        let keterangan = event.relatedTarget.getAttribute('data-bs-keterangan');
        this.querySelector('input[name=paket]').value = paket;
        $(this).find('#keteranganedit').text(keterangan);

        this.querySelector('#formUpdate').setAttribute('action', '{{ route("backend.terumumkan.index") }}/' + event.relatedTarget.getAttribute('data-bs-id'));
      });
      modalEdit.addEventListener('hidden.bs.modal', function (event) {
        this.querySelector('input[name=paket]').value ='';
        $(this).find('#keteranganedit').text('');
        this.querySelector('#formUpdate').setAttribute('href', '');
      });
      modalDelete.addEventListener('show.bs.modal', function (event) {
        let button = event.relatedTarget;
        let id = button.getAttribute('data-bs-id');
        this.querySelector('.urlDelete').setAttribute('href', '{{ route("backend.terumumkan.index") }}/' + id);
      });
      modalDelete.addEventListener('hidden.bs.modal', function (event) {
        this.querySelector('.urlDelete').setAttribute('href', '');
      });

      select2Paket.select2({
        dropdownParent: select2Paket.parent(),
        placeholder: "Pilih Paket",
        searchInputPlaceholder: 'Cari Paket',

        allowClear: true,
        width: '100%',
        ajax: {
          url: "{{ route('backend.paket.select2') }}",
          dataType: "json",
          cache: true,
          data: function (e) {
            return {
              q: e.term || '',
              page: e.page || 1,
              status: 'Aktif'
            }
          },
        },
      });
      $("#formStore").submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let btnSubmit = form.find("[type='submit']");
        let btnSubmitHtml = btnSubmit.html();
        let url = form.attr("action");
        let data = new FormData(this);
        $.ajax({
          beforeSend: function () {
            btnSubmit.addClass("disabled").html("<span aria-hidden='true' class='spinner-border spinner-border-sm' role='status'></span> Loading ...").prop("disabled", "disabled");
          },
          cache: false,
          processData: false,
          contentType: false,
          type: "POST",
          url: url,
          data: data,
          success: function (response) {
            let errorCreate = $('#errorCreate');
            errorCreate.css('display', 'none');
            errorCreate.find('.alert-text').html('');
            btnSubmit.removeClass("disabled").html(btnSubmitHtml).removeAttr("disabled");
            if (response.status === "success") {
              toastr.success(response.message, 'Success !');
              dataTable.draw();
              bsCreate.hide();
            } else {
              toastr.error((response.message ? response.message : "Please complete your form"), 'Failed !');
              if (response.error !== undefined) {
                errorCreate.removeAttr('style');
                $.each(response.error, function (key, value) {
                  errorCreate.find('.alert-text').append('<span style="display: block">' + value + '</span>');
                });
              }
            }
          },
          error: function (response) {
            btnSubmit.removeClass("disabled").html(btnSubmitHtml).removeAttr("disabled");
            toastr.error(response.responseJSON.message, 'Failed !');
          }
        });
      });
      $("#formUpdate").submit(function(e){
        e.preventDefault();
        let form 	= $(this);
        let btnSubmit = form.find("[type='submit']");
        let btnSubmitHtml = btnSubmit.html();
        let url 	= form.attr("action");
        let data 	= new FormData(this);
        $.ajax({
          beforeSend:function() {
            btnSubmit.addClass("disabled").html("<span aria-hidden='true' class='spinner-border spinner-border-sm' role='status'></span> Loading ...").prop("disabled", "disabled");
          },
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          cache: false,
          processData: false,
          contentType: false,
          type: "POST",
          url : url,
          data : data,
          success: function (response) {
            let errorEdit = $('#errorEdit');
            errorEdit.css('display', 'none');
            errorEdit.find('.alert-text').html('');
            btnSubmit.removeClass("disabled").html(btnSubmitHtml).removeAttr("disabled");
            if (response.status === "success") {
              toastr.success(response.message, 'Success !');
              dataTable.draw();
              bsEdit.hide();
            } else {
              toastr.error((response.message ? response.message : "Please complete your form"), 'Failed !');
              if (response.error !== undefined) {
                errorEdit.removeAttr('style');
                $.each(response.error, function (key, value) {
                  errorEdit.find('.alert-text').append('<span style="display: block">' + value + '</span>');
                });
              }
            }
          },
          error: function (response) {
            btnSubmit.removeClass("disabled").html(btnSubmitHtml).removeAttr("disabled");
            toastr.error(response.responseJSON.message, 'Failed !');
          }
        });
      });
      $("#formDelete").click(function (e) {
        e.preventDefault();
        let form = $(this);
        let url = modalDelete.querySelector('.urlDelete').getAttribute('href');
        let btnHtml = form.html();
        let spinner = $("<span aria-hidden='true' class='spinner-border spinner-border-sm' role='status'></span>");
        $.ajax({
          beforeSend: function () {
            form.text(' Loading. . .').prepend(spinner).prop("disabled", "disabled");
          },
          type: 'DELETE',
          url: url,
          dataType: 'json',
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          success: function (response) {
            toastr.success(response.message, 'Success !');
            form.text('Submit').html(btnHtml).removeAttr('disabled');
            dataTable.draw();
            bsDelete.hide();
          },
          error: function (response) {
            toastr.error(response.responseJSON.message, 'Failed !');
            form.text('Submit').html(btnHtml).removeAttr('disabled');
            bsDelete.hide();
          }
        });
      });

    });
  </script>
@endsection
