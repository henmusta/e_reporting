@extends('layouts.master')

@section('title') {{ $config['page_title'] }} @endsection

@section('content')
<div class="row">

    <div class="col-xl-3 col-lg-6">
        <div class="box" style="border-style: solid;
        border-color: grey;">
            <div class="box-body text-center">
                <h2 class="my-0">{{$data['terumumkan']}}</h2>
                <p class="mb-0 text-fade">Terumumkan</p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6">
        <div class="box" style="border-style: solid;
        border-color: #172b4c;">
            <div class="box-body text-center">
                <h2 class="my-0">{{$data['proseskontrak']}}</h2>
                <p class="mb-0 text-fade">Proses Kontrak</p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6">
        <div class="box" style="border-style: solid;
        border-color: yellow;">
            <div class="box-body text-center">
                <h2 class="my-0">{{$data['pelaksanaan']}}</h2>
                <p class="mb-0 text-fade">Pelaksanaan</p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6">
        <div class="box" style="border-style: solid;
        border-color: green;">
            <div class="box-body text-center">
                <h2 class="my-0">{{$data['selesai']}}</h2>
                <p class="mb-0 text-fade">Selesai</p>
            </div>
        </div>
    </div>

</div>
@endsection

@section('css')

@endsection
@section('script')

  <script>
    $(document).ready(function () {

    });
  </script>
@endsection
