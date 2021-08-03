<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
		<title>Admin Pannel - {{ config('app.name')}} </title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Micro Niche Blog | Admin Pannel">
        <meta name="author" content="Bdtask">
        <meta name="robots" content="noindex, nofollow">
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset("admin-assets/dist/img/favicon.png")}}">
        <!--Global Styles(used by all pages)-->
        <link href="{{ asset("admin-assets/plugins/bootstrap/css/bootstrap.min.css")}}" rel="stylesheet">
        <link href="{{ asset("admin-assets/plugins/metisMenu/metisMenu.min.css")}}" rel="stylesheet">
        <link href="{{ asset("admin-assets/plugins/fontawesome/css/all.min.css")}}" rel="stylesheet">
        <link href="{{ asset("admin-assets/plugins/typicons/src/typicons.min.css")}}" rel="stylesheet">
        <link href="{{ asset("admin-assets/plugins/themify-icons/themify-icons.min.css")}}" rel="stylesheet">
        <!--Third party Styles(used by this page)-->
        <!--Start Your Custom Style Now-->
        <link href="{{ asset("admin-assets/dist/css/style.css")}}" rel="stylesheet">
    </head>
    <body class="bg-white">
        <div class="d-flex align-items-center justify-content-center text-center h-100vh">
            <div class="form-wrapper m-auto">
                <div class="form-container my-4">
                    <div class="register-logo text-center mb-4">
                    </div>
                    <div class="panel">
                        <div class="panel-header text-center mb-3">
                            <h3 class="fs-24">Sign into your account!</h3>
                            <p class="text-muted text-center mb-0">Nice to see you! Please log in with your account.</p>
                        </div>
                        @if (Session::has('message'))
                          <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{!! Session('message') !!}</strong>
                          </div>
                          @endif
                          @if (count($errors) > 0)
                          <div class="alert alert-danger">
                            <ul class="list-unstyled text-left mb-0">
                              @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                              @endforeach
                            </ul>
                          </div>
                          @endif
                        <form class="register-form" action="" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" id="emial" placeholder="Enter email">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control" id="pass" placeholder="Password">
                            </div>
                            <button type="submit" class="btn btn-success btn-block">Sign in</button>
                        </form>
                    </div>
                    <div class="bottom-text text-center my-3">
                        Developed By: <a href="https://dgaps.com/" class="font-weight-500">Digital Applications</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.End of form wrapper -->
        <!--Global script(used by all pages)-->
        <script src="{{ asset("admin-assets/plugins/jQuery/jquery-3.4.1.min.js")}}"></script>
        <script src="{{ asset("admin-assets/dist/js/popper.min.js")}}"></script>
        <script src="{{ asset("admin-assets/plugins/bootstrap/js/bootstrap.min.js")}}"></script>
        <script src="{{ asset("admin-assets/plugins/metisMenu/metisMenu.min.js")}}"></script>
        <script src="{{ asset("admin-assets/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js")}}"></script>
        <!-- Third Party Scripts(used by this page)-->
        <!--Page Active Scripts(used by this page)-->
        <!--Page Scripts(used by all page)-->
        <script src="{{ asset("admin-assets/dist/js/sidebar.js")}}"></script>
    </body>
    <!-- Mirrored from bhulua.thememinister.com/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 03 Jan 2020 04:49:17 GMT -->
</html>