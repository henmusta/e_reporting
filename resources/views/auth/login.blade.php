<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from warehouse-admin-dashboard.multipurposethemes.com/main/auth_login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 07 Jun 2022 11:19:46 GMT -->
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">

    <title>Deposito Admin - Log in </title>

	<!-- Vendors Style-->
	<link rel="stylesheet" href="{{ asset('assets/css/vendors_css.css')}}">

	<!-- Style-->
	<link rel="stylesheet" href="{{ asset('assets/css/style.css')}}">
	<link rel="stylesheet" href="{{ asset('assets/css/skin_color.css')}}">

</head>

<body class="hold-transition theme-primary bg-img" style="background-image: url({{URL::to('storage/images/backend/'.Setting::get_setting()->background)}})">

	<div class="container h-p100">
		<div class="row align-items-center justify-content-md-center h-p100">

			<div class="col-12">
				<div class="row justify-content-center g-0">
					<div class="col-lg-5 col-md-5 col-12">
						<div class="bg-white rounded10 shadow-lg">
							<div class="content-top-agile p-20 pb-0">
								<h2 class="text-primary">{{Setting::get_setting()->nama}}</h2>
								<p class="mb-0">Log In</p>
							</div>
							<div class="p-40">
                                <form class="custom-form mt-4 pt-2 login" method="POST"
                                action="{{ route('backend.login') }}">
                                @csrf
									<div class="form-group">
										<div class="input-group mb-3">
											<span class="input-group-text bg-transparent"><i class="ti-user"></i></span>
                                            <input name="email" type="text"
                                            class="form-control form-control-sm @error('email') is-invalid @enderror"
                                            value="{{ old('email', '') }}" id="username" placeholder="Enter Email"
                                            autocomplete="email" autofocus>
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                           @enderror
										</div>
									</div>
									<div class="form-group">
										<div class="input-group mb-3">
											<span class="input-group-text  bg-transparent"><i class="ti-lock"></i></span>
                                            <input type="password" name="password"
                                            class="form-control form-control-sm  @error('password') is-invalid @enderror"
                                            id="userpassword" placeholder="Enter password">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
										</div>
									</div>
									  <div class="row">
                                        <div class="form-group">
                                            @if (Route::has('password.request'))
                                                <a href="{{ route('password.request') }}"
                                                    class="text-white">Forgot password?</a>
                                            @endif
                                        </div>
										<!-- /.col -->
										<div class="col-12 text-center">
										  <button type="submit" class="btn btn-danger mt-10">SIGN IN</button>
										</div>
										<!-- /.col -->
									  </div>
								</form>

							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- Vendor JS -->
	<script src="{{ asset('assets/js/vendors.min.js')}}"></script>
	<script src="{{ asset('assets/js/pages/chat-popup.js')}}"></script>
    <script src="{{ asset('assets/icons/feather-icons/feather.min.js')}}"></script>

</body>

<!-- Mirrored from warehouse-admin-dashboard.multipurposethemes.com/main/auth_login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 07 Jun 2022 11:19:46 GMT -->
</html>
