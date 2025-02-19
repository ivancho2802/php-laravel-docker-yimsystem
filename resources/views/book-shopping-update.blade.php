@extends('layouts.user_type.auth')

@section('content')

<div class="section min-vh-85 position-relative transform-scale-0 transform-scale-md-7">
  <div class="container">
    <div class="row">
      <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
        <div class="card card-plain mt-8">
          <div class="card-header pb-0 text-left bg-transparent">
            <h3 class="font-weight-bolder text-info text-gradient">Bienvenido</h3>
            <p class="mb-0">Crea una nueva cuenta<br></p>
            <p class="mb-0">O Sign in con estas credenciales:</p>
            <p class="mb-0">Email <b>test@yimsystem.com</b></p>
            <p class="mb-0">Password <b>12345678</b></p>
          </div>
          <div class="card-body">
            <form role="form" method="POST" action="/session">
              @csrf
              <label>Email</label>
              <div class="mb-3">
                <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="" aria-label="Email" aria-describedby="email-addon">
                @error('email')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
              </div>
              <label>Password</label>
              <div class="mb-3">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="" aria-label="Password" aria-describedby="password-addon">
                @error('password')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
              </div>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="rememberMe" checked="">
                <label class="form-check-label" for="rememberMe">Remember me</label>
              </div>
              <div class="text-center">
                <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign in</button>
              </div>
            </form>
          </div>
          <div class="card-footer text-center pt-0 px-lg-2 px-1">
            <small class="text-muted">Recuperar tu password? Reinicia tu password
              <a href="/login/forgot-password" class="text-info text-gradient font-weight-bold">here</a>
            </small>
            <p class="mb-4 text-sm mx-auto">
              ¿No tienes cuenta?
              <a href="register" class="text-info text-gradient font-weight-bold">Sign up</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection