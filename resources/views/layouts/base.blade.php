<!DOCTYPE html>
<html lang="en">
	<head>
		@include('partial.html_header')
	</head>
	<body>
	  <div class="wrapper">
  	  <div class="sidebar" data-color="blue" data-image="{{ url('/img/sidebar.jpg') }}">
  			@include('partial.html_sidebar')
  	  </div>
	    <div class="main-panel">
  			@include('partial.html_nav')

        {{-- content --}}
  			<div class="content">
  				<div class="container-fluid">
  					@yield('content')
  				</div>
  			</div>

				@include('partial.html_footer')
			</div>
		</div>
		<script src="{{ url('/js/app.js') }}"></script>
	</body>
</html>
