<!DOCTYPE html>
<html lang="en">
	<head>
		@include('layouts.partial.html_header')
	</head>
	<body>
		<div class="wrapper">
		  <div class="sidebar" data-color="blue" data-image="{{ url('/img/sidebar.jpg') }}">
		    @include('layouts.partial.html_sidebar')
		  </div>
		  <div class="main-panel">
		    @include('layouts.partial.html_nav')

		    {{-- content --}}
		    <div class="content">
		      <div class="container-fluid">
		        @yield('content')
		      </div>
		    </div>

		    @include('layouts.partial.html_footer')
		  </div>
		</div>
		@include('layouts.partial.html_footer_js')
	</body>
</html>
