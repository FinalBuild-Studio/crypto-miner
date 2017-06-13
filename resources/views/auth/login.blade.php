<!DOCTYPE html>
<html lang="en" class="perfect-scrollbar-off">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title></title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta name="viewport" content="width=device-width">
    <link href="{{ url('/css/app.css') }}" rel="stylesheet">
  </head>
  <body>
    <div class="wrapper wrapper-full-page">
      <div class="full-page login-page" filter-color="black">
        <div class="content">
          <div class="container">
            <div class="row">
              <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                <form method="#" action="#">
                  <div class="card card-login">
                    <div class="card-header text-center" data-background-color="blue">
                      <h4 class="card-title">登入</h4>
                    </div>
                    <div class="card-content">
                      <a href="{{ action('Auth\Login\AuthController@login', 'facebook') }}" class="btn btn-block btn-social btn-facebook">
                        <span class="fa fa-facebook"></span>&nbsp;&nbsp;&nbsp;
                        Sign in with Facebook
                      </a>
                      <a href="{{ action('Auth\Login\AuthController@login', 'github') }}" class="btn btn-block btn-social btn-github">
                        <span class="fa fa-github"></span>&nbsp;&nbsp;&nbsp;
                        Sign in with Github
                      </a>
                      <a href="{{ action('Auth\Login\AuthController@login', 'google') }}" class="btn btn-block btn-social btn-google">
                        <span class="fa fa-google"></span>&nbsp;&nbsp;&nbsp;
                        Sign in with Google
                      </a>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <footer class="footer">
          <div class="container">
            <p class="copyright pull-right">
              ©
              <script>
                document.write(new Date().getFullYear())
              </script>
              <a href="https://blog.capslock.tw">CapsLock, Studio</a>, made by Michael
            </p>
          </div>
        </footer>
      </div>
    </div>
    <script src="{{ url('/js/app.js') }}" charset="utf-8"></script>
  </body>
</html>
