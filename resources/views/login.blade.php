{{-- @extends('layouts.admin.main') --}}
<html>
<head>
    @include('partials.header')
</head>

<body class="hold-transition login-page">
    <div class="login-box">
      <!-- /.login-logo -->
      <div class="card">
        <!-- <div class="card-header text-center">
          <a href="../index2.html" class="h1"><b>Admin</b>LTE</a>
        </div> -->
        <div class="card-body">
            <div class="text-center mb-1">
                <img src="{{ asset('dist/img/logo-arsitektur-UIN-Malang.png') }}" width="100px" alt="logo Prodi Arsitektur UIN Malang">
            </div>
            <h3 class="text-center">OBE Arsitektur</h3>
            <p class="login-box-msg">Enter your details to get sign in to your account</p>

            @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
          <form action="{{ route('login') }}" method="post">
            @CSRF
            <div class="input-group mb-3">
              <input type="text" name="username" class="form-control" placeholder="Username">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
            <div class="input-group">
              <input type="password" name="password" class="form-control" placeholder="Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <p class="text-end">
                <a href="forgot-password.html" class="text-dark">Forgot Password?</a>
            </p>
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </form>

          <!-- <div class="social-auth-links text-center mt-2 mb-3">
            <a href="#" class="btn btn-block btn-primary">
              <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
            </a>
            <a href="#" class="btn btn-block btn-danger">
              <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
            </a>
          </div> -->
          <!-- /.social-auth-links -->
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.login-box -->

    {{-- @include('layouts.admin.script') --}}
    </body>
    </html>
