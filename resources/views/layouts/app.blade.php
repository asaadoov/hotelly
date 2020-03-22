<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ config('app.name', 'Laravel') }}</title>

		<!-- Scripts -->
		<script src="{{ asset('js/app.js') }}" defer></script>
		<!-- Bootstrap Core and vandor -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" />
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css">

		<!-- Fonts -->
		<link href="//fonts.gstatic.com" rel="dns-prefetch" >
		<link href="{{asset('css/all.min.css')}}" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


		<!-- Styles -->
		<!-- <link href="{{ asset('css/app1.min.css') }}" rel="stylesheet"> -->
		<link rel="stylesheet" href="{{ asset('css/sb-admin-2.min.css') }}" >
		<link rel="stylesheet" href="{{ asset('css/main.css') }}"/>
		<link rel="stylesheet" href="{{ asset('css/theme1.css') }}"/>
		<link rel="stylesheet" href="{{ asset('css/global.css') }}"/>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"/>
		

		@stack('css')
</head>
<body id="page-top">
		<div id="app">
			<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
					<div class="container">
							<a class="navbar-brand" href="{{ url('/') }}">
									{{ config('app.name', 'Laravel') }}
							</a>
							<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
									<span class="navbar-toggler-icon"></span>
							</button>

							<div class="collapse navbar-collapse" id="navbarSupportedContent">
									<!-- Left Side Of Navbar -->
									<ul class="navbar-nav mr-auto">

									</ul>

									<!-- Right Side Of Navbar -->
									<ul class="navbar-nav ml-auto">
											<!-- Authentication Links -->
											@guest
													<li class="nav-item">
															<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
													</li>
													@if (Route::has('register'))
															<li class="nav-item">
																	<a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
															</li>
													@endif
											@else
													<li class="nav-item dropdown">
															<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
																	{{ Auth::user()->name }} <span class="caret"></span>
															</a>

															<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
																	<a class="dropdown-item" href="{{ route('logout') }}"
																			onclick="event.preventDefault();
																										document.getElementById('logout-form').submit();">
																			{{ __('Logout') }}
																	</a>

																	<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
																			@csrf
																	</form>
															</div>
													</li>
											@endguest
									</ul>
							</div>
					</div>
			</nav>
		</div>

	<main role="main">
			<div class="container mt-5">
					<div class="row">
							<!-- Buttons -->
							@yield('buttons')
					</div>
			</div>
			<div class="container mt-1">
					<div class="row">
							<!-- Content -->
							@yield('content')
					</div>
			</div>
	</main>

	<footer class="container mt-5">
		<p class="float-right"><a href="#">Back to top</a></p>
		<p>&copy; 2017-2019 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
	</footer>

	<div id="div-modal"></div>
	@stack('modal')

	
	<script src="{{ asset('bundles/lib.vendor.bundle.js') }}"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
	<script src="{{ asset('plugins/animated-modal/animatedModal.min.js') }}"></script>

	<script src="{{ asset('js/core.js') }}"></script>
	<script src="{{ asset('js/global.js') }}"></script>


	@stack('js')

</body>
</html>
