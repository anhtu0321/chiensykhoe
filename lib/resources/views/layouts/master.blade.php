<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="x-ua-compatible" content="ie=edge">
	@yield('title')
	<link rel="stylesheet" href="{{asset('lib/public/plugins/fontawesome-free/css/all.min.css')}}">
	<link rel="stylesheet" href="{{asset('lib/public/bootstrap/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('lib/public/css/mystyle.css')}}">
	

</head>
<body>
	<div class="wrapper" id="app">
		@include('layouts.header')
		@include('layouts.sidebar')
		@yield('content')
		@include('layouts.footer')
	</div>
<script src="{{asset('lib/public/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('lib/public/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('lib/public/js/app.js')}}"></script>
<script src="{{asset('lib/public/js/myjs.js')}}"></script>
</body>
</html>