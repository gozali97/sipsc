
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
	<link rel="stylesheet" type="text/css" href="{{ url('assets/src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ url('assets/src/plugins/datatables/css/responsive.bootstrap4.min.css') }}">

    	<!-- switchery css -->
	<link rel="stylesheet" type="text/css" href="{{ url('assets/src/plugins/switchery/switchery.min.css') }}">
	<!-- bootstrap-tagsinput css -->
	<link rel="stylesheet" type="text/css" href="{{ url('assets/src/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
	<!-- bootstrap-touchspin css -->
	<link rel="stylesheet" type="text/css" href="{{ url('assets/src/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ url('assets/vendors/styles/style.css') }}">

     <!-- Tambahkan link jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Tambahkan link DataTables CDN -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.25/datatables.min.css"/>

    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.25/datatables.min.js"></script>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.all.min.js"></script>

	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-119386393-1');
	</script>
</head>
<body>
	<div class="pre-loader">
		<div class="pre-loader-box">
			<div class="loader-logo"><img src="{{ url('assets/img/logosmk.png') }}" alt=""></div>
			<div class='loader-progress' id="progress_div">
				<div class='bar' id='bar1'></div>
			</div>
			<div class='percent' id='percent1'>0%</div>
			<div class="loading-text">
				Loading...
			</div>
		</div>
	</div>

@include('layouts.header')
@include('layouts.sidebar')


	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
            @yield('content')
	</div>
	<!-- js -->
	<script src="{{ url('assets/vendors/scripts/core.js') }}"></script>
	<script src="{{ url('assets/vendors/scripts/script.min.js') }}"></script>
	<script src="{{ url('assets/vendors/scripts/process.js') }}"></script>
	<script src="{{ url('assets/vendors/scripts/layout-settings.js') }}"></script>
	{{-- <script src="{{ url('assets/src/plugins/apexcharts/apexcharts.min.js') }}"></script> --}}
	<script src="{{ url('assets/src/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ url('assets/src/plugins/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ url('assets/src/plugins/datatables/js/dataTables.responsive.min.js') }}"></script>
	<script src="{{ url('assets/src/plugins/datatables/js/responsive.bootstrap4.min.js') }}"></script>
	<script src="{{ url('assets/vendors/scripts/dashboard.js') }}"></script>

    {{-- <script src="{{ url('assets/src/plugins/datatables/js/dataTables.buttons.min.js') }}"></script>
	<script src="{{ url('assets/src/plugins/datatables/js/buttons.bootstrap4.min.js') }}"></script>
	<script src="{{ url('assets/src/plugins/datatables/js/buttons.print.min.js') }}"></script>
	<script src="{{ url('assets/src/plugins/datatables/js/buttons.html5.min.js') }}"></script>
	<script src="{{ url('assets/src/plugins/datatables/js/buttons.flash.min.js') }}"></script>
	<script src="{{ url('assets/src/plugins/datatables/js/pdfmake.min.js') }}"></script>
	<script src="{{ url('assets/src/plugins/datatables/js/vfs_fonts.js') }}"></script> --}}
	<!-- Datatable Setting js -->
	<script src="{{ url('assets/vendors/scripts/datatable-setting.js') }}"></script></body>
    <!-- switchery js -->
	<script src="{{ url('assets/src/plugins/switchery/switchery.min.js') }}"></script>
	<!-- bootstrap-tagsinput js -->
	<script src="{{ url('assets/src/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
	<!-- bootstrap-touchspin js -->
	<script src="{{ url('assets/src/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.js') }}"></script>
	<script src="{{ url('assets/vendors/scripts/advanced-components.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>
</html>
