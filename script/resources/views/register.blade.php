@extends('auth.main')
@section('content')
    <div class="card-header">
        <h4>{{ __('Sign up') }}</h4>
    </div>
    <div class="card-body">

        @if(Session::has('error'))
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                {{ Session::get('error') }}
            </div>
        @endif
        <form method="POST" id="ajaxform" class="needs-validation" action="{{ route('user.store') }}">
            @csrf
            <div class="form-group">
                <label>{{ __('Full Name') }}</label>
                <input type="text" class="form-control @error('full_name') is-invalid @enderror"  name="full_name">
                @error('full_name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">{{ __('E-Mail Address') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus >
                @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                    <label for="password" class="control-label">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control  @error('password') is-invalid @enderror" name="password" required >
                @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('Confirm Password') }}</label>
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation">
                @error('password_confirmation')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        {{ __('Sign Up') }}
                    </button>
                </div>
            <div class="already-have-member">
                <p>{{ __('Already a member?') }}<a href="{{ route('login') }}"> {{ __('Sign In') }}</a></p>
            </div>
        </form>
        <div class="simple-footer">
            {{ __('Copyright') }} &copy; {{ Config::get('app.name') }} {{ date('Y') }}
        </div>
    </div>
@endsection



