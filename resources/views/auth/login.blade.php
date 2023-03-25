
<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>SIPSC | Sistem Informasi Perpustakaan Berbasis Web</title>

	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="{{ url('assets/img/logosmk.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ url('assets/img/logosmk.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ url('assets/img/logosmk.png') }}">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="{{ url('assets/vendors/styles/core.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ url('assets/vendors/styles/icon-font.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ url('assets/vendors/styles/style.css') }}">

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-119386393-1');
	</script>
    <style>
        .img{
            width: 60px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 10px;
        }
        .bg{
            border-radius: 5%;
        }
    </style>
</head>
<body class="login-page">
	<div class="login-header box-shadow">
		<div class="container-fluid d-flex justify-content-between align-items-center">
			<div class="brand-logo">
				<a href="login.html">
					<h5 class="text-secondary">Sistem Informasi Perpustakaan Berbasis Web</h5>
				</a>
			</div>
			<div class="login-menu">
				{{-- <ul>
					<li><a href="register.html">Register</a></li>
				</ul> --}}
			</div>
		</div>
	</div>
	<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6 col-lg-7">
					<img class="bg" src="{{ url('assets/img/perpustakaan.jpg') }}" alt="">
				</div>
				<div class="col-md-6 col-lg-5">
					<div class="login-box bg-white box-shadow border-radius-10">
						<div class="login-title">
                            <img class="img" src="{{ url('assets/img/logosmk.png') }}" alt="">
							<h2 class="text-center text-primary">Login To SIPSC</h2>
						</div>
						<form method="POST" action="{{ route('login') }}">
                            @csrf
							<div class="input-group custom">
								<input class="form-control form-control-lg @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
								</div>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
							</div>
							<div class="input-group custom">
								<input class="form-control form-control-lg @error('password') is-invalid @enderror" id="password" type="password" name="password" required autocomplete="current-password" placeholder="Password">
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
								</div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>
							<div class="row pb-30">
								<div class="col-6">
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="customCheck1">
										<label class="custom-control-label" for="customCheck1">Remember</label>
									</div>
								</div>
								{{-- <div class="col-6">
									<div class="forgot-password"><a href="forgot-password.html">Forgot Password</a></div>
								</div> --}}
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="input-group mb-0">
										<!--
											use code for form submit
											<input class="btn btn-primary btn-lg btn-block" type="submit" value="Sign In">
										-->
										<button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- js -->
	<script src="{{ url('assets/vendors/scripts/core.js') }}"></script>
	<script src="{{ url('assets/vendors/scripts/script.min.js') }}"></script>
	<script src="{{ url('assets/vendors/scripts/process.js') }}"></script>
	<script src="{{ url('assets/vendors/scripts/layout-settings.js') }}"></script>
</body>
</html>
