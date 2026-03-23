@extends('layouts.app')

@section('content')
<style>
  .marker-admin-box-wrap {
    display: flex;
    justify-content: flex-end;
    margin-top: 1rem;
    margin-bottom: 2rem;
  }

  .marker-admin-box {
    max-width: 24rem;
    width: 100%;
    border: 1px solid #c5ccd3;
    border-radius: 0.5rem;
    padding: 0.9rem 1rem;
    background-color: #ffffff;
    color: #1c232b;
    font-size: 0.92rem;
    line-height: 1.45;
  }

  .marker-admin-box__title {
    font-weight: 600;
    margin-bottom: 0.35rem;
  }

  html[data-theme="dark"] .marker-admin-box {
    border-color: #5c646d;
    background-color: #2d3136;
    color: #f1f3f5;
  }
</style>

<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="login-register container">
      <ul class="nav nav-tabs mb-5" id="login_register" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link nav-link_underscore active" id="login-tab" data-bs-toggle="tab" href="#tab-item-login"
            role="tab" aria-controls="tab-item-login" aria-selected="true">Login</a>
        </li>
      </ul>
      <div class="tab-content pt-2" id="login_register_tab_content">
        <div class="tab-pane fade show active" id="tab-item-login" role="tabpanel" aria-labelledby="login-tab">
          <div class="login-form">
            <form method="POST" action="{{ route('login') }}" name="login-form" class="needs-validation" novalidate="">
                @csrf
                <div class="form-floating mb-3">
                <input id="email" class="form-control form-control_gray @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required="" autocomplete="email" autofocus="">
                <label for="email">Email address *</label>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>

              <div class="pb-3"></div>

              <div class="form-floating mb-3">
                <input id="password" type="password" class="form-control form-control_gray @error('password') is-invalid @enderror" name="password" required="" autocomplete="current-password">
                <label for="password">Password *</label>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>

              <button class="btn btn-primary w-100 text-uppercase" type="submit">Log In</button>

              <div class="customer-option mt-4 text-center">
                <span class="text-secondary">No account yet?</span>
                <a href="{{ route('register') }}" class="btn-text js-show-register">Create Account</a> | <a href="{{ route('password.request') }}" class="btn-text js-show-register">Forgot Password</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
    <section class="container">
      <div class="marker-admin-box-wrap">
        <div class="marker-admin-box">
          <div class="marker-admin-box__title">Admin details for Marker</div>
          <div>Email: AdminMaker@aston.ac.uk</div>
          <div>Password: Marker123</div>
        </div>
      </div>
    </section>
  </main>


@endsection
