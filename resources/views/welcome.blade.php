<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
      <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
      <meta name="description" content="{{ env('APP_NAME', 'Laravel Application') }}">
	<meta name="author" content="{{ env('APP_NAME', 'Laravel Application') }}">
	<meta name="keywords" content="{{ env('APP_NAME', 'Laravel Application') }}, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<title>{{ env('APP_NAME', 'Laravel Application') }}</title>

      <!-- Fonts -->
      <link rel="preconnect" href="https://fonts.googleapis.com/">
      <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&amp;display=swap" rel="stylesheet">
      <!-- End fonts -->

	<!-- core:css -->
	<link rel="stylesheet" href="{{ asset('backend/assets/vendors/core/core.css') }}">
	<!-- endinject -->

	<!-- Plugin css for this page -->
      <link rel="stylesheet" href="{{ asset('backend/assets/vendors/flatpickr/flatpickr.min.css') }}">
	<!-- End plugin css for this page -->

	<!-- inject:css -->
	<link rel="stylesheet" href="{{ asset('backend/assets/fonts/feather-font/css/iconfont.css') }}">
	<link rel="stylesheet" href="{{ asset('backend/assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
	<!-- endinject -->

      <!-- Layout styles -->  
	<link rel="stylesheet" href="{{ asset('backend/assets/css/demo1/style.min.css') }}">
      <!-- End layout styles -->

      <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.png') }}" />

      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
      <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
      {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    @vite('resources/css/app.css')
</head>
<body>
    <div id="app"></div>

    @vite('resources/js/app.js')
{{-- <script src="{{ asset('js/app.js') }}"></script> --}}
{{-- @vite('resources/js/app.js') --}}
<!-- core:js Jquery -->
<script src="{{ asset('backend/assets/vendors/core/core.js') }}"></script>
<!-- endinject -->

<!-- inject:js -->
<script src="{{ asset('backend/assets/vendors/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/template.js') }}"></script>
<!-- endinject -->

</body>
</html>