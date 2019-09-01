@extends("layouts.app")
@section("title") Laramart @endsection

@section("content")
    <div class="card card-primary">
        <div class="card-header"><h4>{{ __('Login') }}</h4></div>

        <div class="card-body">
        <form method="POST" action="{{route('login')}}" class="needs-validation" novalidate="">
            @csrf
            <div class="form-group">
            <label for="email">{{ __('E-Mail Address') }}</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" tabindex="1" required autofocus>
            @error('email')
            <div class="invalid-feedback">
               {{ $message }}
            </div>
            @enderror
            </div>

            <div class="form-group">
            <div class="d-block">
                <label for="password" class="control-label">{{ __('Password') }}</label>
                <div class="float-right">
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-small">
                    Forgot Password?
                </a>
                @endif
                </div>
            </div>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" tabindex="2" required>
            @error('password')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
            </div>

            <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me" {{ old('remember') ? 'checked' : '' }}>
                <label class="custom-control-label" for="remember-me">{{ __('Remember Me') }}</label>
            </div>
            </div>

            <div class="form-group">
            <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
            {{ __('Login') }}
            </button>
            </div>
        </form>
        <div class="text-center mt-4 mb-3">
            <div class="text-job text-muted">Login With Social</div>
        </div>
        <div class="row sm-gutters">
            <div class="col-6">
            <a class="btn btn-block btn-social btn-facebook">
                <span class="fab fa-facebook"></span> Facebook
            </a>
            </div>
            <div class="col-6">
            <a class="btn btn-block btn-social btn-twitter">
                <span class="fab fa-twitter"></span> Twitter
            </a>                                
            </div>
        </div>

        </div>
    </div>
    <div class="mt-5 text-muted text-center">
        Don't have an account? <a href="auth-register.html">Create One</a>
    </div>
@endsection