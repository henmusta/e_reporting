<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{URL::to('storage/images/backend/'.Setting::get_setting()->favicon)}}">

    <title>{{Setting::get_setting()->nama}}</title>

    @include('layouts.headercss')

  </head>

<body class="hold-transition light-skin sidebar-mini theme-primary fixed">
<div class="wrapper">

  <div id="loader"></div>

  <header class="main-header">
    @include('layouts.header')
  </header>

  <aside class="main-sidebar">
    @include('layouts.sidebar')
  </aside>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
	  <div class="container-full">
        <div class="content-header">
			<div class="d-flex align-items-center">
				<div class="me-auto">
					{{-- <h4 class="page-title">Data Tables</h4> --}}
					<div class="d-inline-block align-items-center">
						<nav>
                            @component('components.breadcrumb', ['page_breadcrumbs' => $page_breadcrumbs])
                            @slot('title'){{ $config['page_title'] }} @endslot
                           @endcomponent
						</nav>
					</div>
				</div>

			</div>
		</div>
		<!-- Main content -->
		<section class="content">

            @yield('content')
		</section>
		<!-- /.content -->
	  </div>
  </div>
  @include('layouts.footer')

  <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>


	<!-- Page Content overlay -->

    @include('layouts.footerjs')


</body>

<!-- Mirrored from warehouse-admin-dashboard.multipurposethemes.com/main/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 07 Jun 2022 11:19:10 GMT -->
</html>
