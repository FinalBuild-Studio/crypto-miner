<nav class="navbar navbar-transparent navbar-absolute">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">@yield('title')</a>
    </div>
    <div class="collapse navbar-collapse">
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
	 			    <i class="material-icons">person</i>
	 			    <p class="hidden-lg hidden-md">Profile</p>
	 			    <div class="ripple-container"></div>
          </a>
          <ul class="dropdown-menu">
            <li>
              <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">登出</a>
              <form id="logout-form" action="{{ action('Auth\LogoutController@store') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
                <input type="submit" value="logout" style="display: none;">
              </form>
            </li>
					</ul>
				</li>
			</ul>
		</div>
  </div>
</nav>
