<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="x-ua-compatible" content="ie=edge">
	@yield('title')
	<link rel="stylesheet" href="{{asset('lib/public/plugins/fontawesome-free/css/all.min.css')}}">
	<link rel="stylesheet" href="{{asset('lib/public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
	<link rel="stylesheet" href="{{asset('lib/public/dist/css/adminlte.min.css')}}">

</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
	<div class="wrapper" id="appbackend">
		@include('backend.layouts.header')
		@include('backend.layouts.sidebar')
		<div class="content-wrapper">
			@yield('content')
		</div>
	<aside class="control-sidebar control-sidebar-dark">
	{{--Bang tuy chon che do hien thi  --}}
	</aside>

		@include('backend.layouts.footer')
	</div>
<script src="{{asset('lib/public/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('lib/public/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('lib/public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<script src="{{asset('lib/public/dist/js/adminlte.js')}}"></script>
<script src="{{asset('lib/public/dist/js/demo.js')}}"></script>
<script src="{{asset('lib/public/plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
<script src="{{asset('lib/public/plugins/raphael/raphael.min.js')}}"></script>
<script src="{{asset('lib/public/plugins/jquery-mapael/jquery.mapael.min.js')}}"></script>
<script src="{{asset('lib/public/plugins/jquery-mapael/maps/usa_states.min.js')}}"></script>
<script src="{{asset('lib/public/plugins/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('lib/public/jsbackend/app.js')}}"></script>
</body>
</html>
